<?php
// app/Http/Controllers/AI/AIConversationController.php

namespace App\Http\Controllers\AI;

use App\Http\Controllers\Controller;
use App\Models\AIConversation;
use App\Models\Lesson;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AIConversationControllerx extends Controller
{
    protected $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function ask(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:2000',
            'lesson_id' => 'nullable|exists:lessons,id',
            'context' => 'required|in:lesson_help,general_question,feedback',
        ]);

        $user = Auth::user();
        $lesson = $validated['lesson_id'] ? Lesson::find($validated['lesson_id']) : null;

        // Générer la réponse IA
        $response = $this->aiService->generateResponse(
            $validated['message'],
            $validated['context'],
            $lesson,
            $user->preferences,
            $this->getRecentConversations($user, $lesson)
        );

        // Sauvegarder la conversation
        $conversation = AIConversation::create([
            'user_id' => $user->id,
            'lesson_id' => $lesson?->id,
            'context' => $validated['context'],
            'user_message' => $validated['message'],
            'ai_response' => $response,
        ]);

        return response()->json([
            'success' => true,
            'response' => $response,
            'conversation_id' => $conversation->id,
        ]);
    }

    public function history(Request $request)
    {
        $user = Auth::user();

        $query = AIConversation::where('user_id', $user->id)
            ->with('lesson');

        if ($request->has('lesson_id')) {
            $query->where('lesson_id', $request->lesson_id);
        }

        if ($request->has('context')) {
            $query->where('context', $request->context);
        }

        $conversations = $query->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('ai.history', compact('conversations'));
    }

    private function getRecentConversations($user, $lesson = null)
    {
        $query = AIConversation::where('user_id', $user->id);

        if ($lesson) {
            $query->where('lesson_id', $lesson->id);
        }

        return $query->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
    }
}
