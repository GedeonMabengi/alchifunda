<?php

namespace App\Http\Controllers\AI;

use App\Http\Controllers\Controller;
use App\Models\AIConversation;
use App\Services\OpenRouterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AIConversationController extends Controller
{
    protected OpenRouterService $aiService;

    public function __construct(OpenRouterService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function assistant(Request $request)
    {
        $user = Auth::user();

        $conversations = AIConversation::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $activeConversation = null;
        if ($request->has('conversation')) {
            $activeConversation = AIConversation::where('user_id', $user->id)
                ->find($request->conversation);
        }

        return view('ai.history', compact('conversations', 'activeConversation'));
    }

    public function history(Request $request)
    {
        return redirect()->route('ai.assistant', $request->all());
    }

    public function showConversation($id)
    {
        return redirect()->route('ai.assistant', ['conversation' => $id]);
    }

    public function askGeneral(Request $request)
    {
        $user = Auth::user();
        $startTime = microtime(true);

        // ✅ Validation JSON-friendly
        $validator = Validator::make($request->all(), [
            'message' => 'nullable|string|max:4000',
            'file' => 'nullable|file|max:20480', // 20MB
            'context' => 'nullable|string|in:lesson_help,general_question,file_analysis',
            'lesson_id' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            Log::warning('AI askGeneral: validation failed', [
                'user_id' => $user?->id,
                'errors' => $validator->errors()->toArray(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $fileData = null;
        $attachmentPath = null;
        $attachmentFilename = null;
        $attachmentMimeType = null;

        try {
            Log::info('AI askGeneral: request received', [
                'user_id' => $user?->id,
                'has_file' => $request->hasFile('file'),
                'message_len' => strlen((string) $request->message),
                'context' => $request->context,
                'model' => env('OPENROUTER_MODEL', 'openrouter/free'),
            ]);

            // ✅ Fichier
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                $allowedMimes = [
                    'image/jpeg', 'image/png', 'image/gif', 'image/webp',
                    'application/pdf',
                    'audio/mpeg', 'audio/wav', 'audio/mp3', 'audio/ogg',
                    'video/mp4', 'video/mpeg',
                    'text/plain',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                ];

                $mime = $file->getMimeType();
                if (!in_array($mime, $allowedMimes)) {
                    Log::warning('AI askGeneral: unsupported file type', [
                        'user_id' => $user->id,
                        'mime' => $mime,
                        'filename' => $file->getClientOriginalName(),
                    ]);

                    return response()->json([
                        'success' => false,
                        'message' => 'Type de fichier non supporté. Utilisez: images, PDF, audio, vidéo, Word.',
                    ], 422);
                }

                $attachmentPath = $file->store('ai_files/' . $user->id, 'private');
                $attachmentFilename = $file->getClientOriginalName();
                $attachmentMimeType = $mime;

                $fileData = [
                    'mime_type' => $attachmentMimeType,
                    'data' => base64_encode(file_get_contents($file->getPathname())),
                    'filename' => $attachmentFilename,
                ];

                Log::info('AI askGeneral: file prepared', [
                    'user_id' => $user->id,
                    'filename' => $attachmentFilename,
                    'mime' => $attachmentMimeType,
                    'size' => $file->getSize(),
                    'stored_path' => $attachmentPath,
                ]);
            }

            $context = $request->context ?? ($fileData ? 'file_analysis' : 'general_question');

            $message = trim((string) $request->message);
            if ($message === '' && $fileData) {
                $message = 'Analyse ce document et explique-moi ce que tu vois.';
            }
            if ($message === '' && !$fileData) {
                $message = 'Bonjour, peux-tu m’aider en chimie ?';
            }

            Log::info('AI askGeneral: calling OpenRouter', [
                'user_id' => $user->id,
                'context' => $context,
                'has_attachment' => (bool) $fileData,
                'model' => env('OPENROUTER_MODEL', 'openrouter/free'),
            ]);

            $responseText = $this->aiService->analyzeMultimodal(
                $message,
                $fileData ? [$fileData] : [],
                [
                    'user_level' => $user->profile->declared_level_id ?? 'secondaire',
                    'subject' => 'chimie',
                ]
            );

            $conversation = AIConversation::create([
                'user_id' => $user->id,
                'lesson_id' => $request->lesson_id ?? null,
                'context' => $context,
                'user_message' => $message,
                'ai_response' => $responseText,
                'attachment_filename' => $attachmentFilename,
                'attachment_mime_type' => $attachmentMimeType,
                'attachment_path' => $attachmentPath,
                'has_attachment' => !empty($fileData),
                'metadata' => [
                    'processing_time_ms' => round((microtime(true) - $startTime) * 1000),
                    'provider' => 'openrouter',
                    'model' => env('OPENROUTER_MODEL', 'openrouter/free'),
                    'file_size' => $request->hasFile('file') ? $request->file('file')->getSize() : null,
                ],
            ]);

            Log::info('AI askGeneral: success', [
                'user_id' => $user->id,
                'conversation_id' => $conversation->id,
                'time_ms' => round((microtime(true) - $startTime) * 1000),
            ]);

            return response()->json([
                'success' => true,
                'response' => $responseText,
                'conversation_id' => $conversation->id,
                'processing_time' => round((microtime(true) - $startTime) * 1000),
            ]);

        } catch (\Throwable $e) {
            Log::error('AI askGeneral: exception', [
                'user_id' => $user?->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
