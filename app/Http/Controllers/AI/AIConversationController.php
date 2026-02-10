<?php

namespace App\Http\Controllers\AI;

use App\Http\Controllers\Controller;
use App\Models\AIConversation;
use App\Models\Lesson;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AIConversationController extends Controller
{
    protected $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Page principale de l'assistant IA avec chat intégré
     */
    public function assistant(Request $request)
    {
        Log::info('=== AI ASSISTANT ACCÈS ===', [
            'user_id' => Auth::id(),
            'ip' => $request->ip(),
            'timestamp' => now()->toIso8601String()
        ]);

        try {
            $user = Auth::user();

            // Vérifier si on charge une conversation spécifique
            $conversationId = $request->get('conversation_id');
            $conversation = null;

            if ($conversationId) {
                Log::info('Chargement conversation spécifique', ['conversation_id' => $conversationId]);
                
                $conversation = AIConversation::where('user_id', $user->id)
                    ->with('lesson')
                    ->find($conversationId);

                if (!$conversation) {
                    Log::warning('Conversation non trouvée', ['conversation_id' => $conversationId]);
                } else {
                    Log::info('Conversation chargée', [
                        'conversation_id' => $conversation->id,
                        'message_preview' => Str::limit($conversation->user_message, 50)
                    ]);
                }
            }

            // Récupérer les conversations récentes pour l'historique
            $conversations = AIConversation::where('user_id', $user->id)
                ->with('lesson')
                ->orderBy('created_at', 'desc')
                ->paginate(20);

            Log::info('Conversations récupérées', ['count' => $conversations->count()]);

            return view('ai.history', compact('conversations', 'conversation'));

        } catch (\Exception $e) {
            Log::error('Erreur assistant', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'Erreur lors du chargement de l\'assistant');
        }
    }

    /**
     * Méthode dédiée pour les questions générales (chat principal)
     */
    public function askGeneral(Request $request)
    {
        $startTime = microtime(true);
        
        Log::info('=== AI ASK GENERAL DÉMARRÉ ===', [
            'user_id' => Auth::id(),
            'ip' => $request->ip(),
            'input' => $request->all()
        ]);

        // Validation
        try {
            $validated = $request->validate([
                'message' => 'required|string|max:2000|min:2',
                'context' => 'required|in:lesson_help,general_question,feedback',
                'conversation_id' => 'nullable|integer',
                'lesson_id' => 'nullable|exists:lessons,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation échouée', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Données invalides',
                'errors' => $e->errors()
            ], 422);
        }

        $user = Auth::user();

        try {
            // Vérifier le service AI
            if (!$this->aiService) {
                Log::error('Service AI non initialisé');
                throw new \Exception('Service AI indisponible');
            }

            // Préparer le contexte pour l'IA
            $context = $this->buildContext($user, $validated);

            Log::info('Contexte construit', [
                'user_level' => $context['user_level'] ?? null,
                'has_lesson' => isset($context['lesson_title'])
            ]);

            // Appel à l'API DeepSeek avec timeout et retry
            $response = $this->callAIWithRetry($validated['message'], $context);

            if (!$response['success']) {
                throw new \Exception($response['error'] ?? 'Erreur IA inconnue');
            }

            $aiResponse = $response['content'];

            // Sauvegarder la conversation
            $conversation = $this->saveConversation($user, $validated, $aiResponse);

            $duration = round((microtime(true) - $startTime) * 1000, 2);

            Log::info('=== AI ASK GENERAL SUCCÈS ===', [
                'conversation_id' => $conversation->id,
                'duration_ms' => $duration,
                'response_length' => strlen($aiResponse)
            ]);

            return response()->json([
                'success' => true,
                'response' => $aiResponse,
                'conversation_id' => $conversation->id,
                'created_at' => $conversation->created_at->toIso8601String(),
                'processing_time' => $duration
            ]);

        } catch (\Exception $e) {
            Log::error('=== AI ASK GENERAL ERREUR ===', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'duration_ms' => round((microtime(true) - $startTime) * 1000, 2)
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage(),
                'error_code' => 'AI_ERROR'
            ], 500);
        }
    }

    /**
     * Afficher l'historique complet des conversations
     */
    public function history(Request $request)
    {
        Log::info('AI History accès', ['user_id' => Auth::id()]);
        
        // Rediriger vers assistant pour avoir le chat
        return redirect()->route('ai.assistant', $request->query());
    }

    /**
     * Afficher une conversation spécifique
     */
    public function showConversation($id)
    {
        Log::info('Show conversation', ['conversation_id' => $id, 'user_id' => Auth::id()]);
        
        return redirect()->route('ai.assistant', ['conversation_id' => $id]);
    }

    /**
     * Construire le contexte pour l'IA
     */
    private function buildContext($user, array $validated): array
    {
        $context = [
            'user_level' => $user->profile->assessedLevel?->name ?? 'Non déterminé',
            'user_age' => $user->profile->age,
            'preferences' => [
                'tone' => $user->preferences->tone ?? 'friendly',
                'detail_level' => $user->preferences->detail_level ?? 'moderate',
            ],
            'subject' => 'chimie',
            'program' => 'RDC secondaire',
            'language' => 'français'
        ];

        if (!empty($validated['lesson_id'])) {
            try {
                $lesson = Lesson::find($validated['lesson_id']);
                if ($lesson) {
                    $context['lesson_title'] = $lesson->title;
                    $context['lesson_content'] = Str::limit($lesson->content, 1000);
                    $context['chapter'] = $lesson->chapter?->title;
                }
            } catch (\Exception $e) {
                Log::warning('Erreur chargement leçon pour contexte', ['error' => $e->getMessage()]);
            }
        }

        return $context;
    }

    /**
     * Appel à l'IA avec retry
     */
    private function callAIWithRetry(string $message, array $context, int $maxRetries = 2): array
    {
        $attempt = 0;
        
        while ($attempt < $maxRetries) {
            $attempt++;
            
            try {
                Log::info("Tentative AI #{$attempt}");
                
                $response = $this->aiService->ask($message, $context);
                
                if (empty($response) || $response === "Aucune réponse reçue de l'API") {
                    throw new \Exception('Réponse vide de l\'IA');
                }

                // Vérifier si c'est une erreur
                if (str_starts_with($response, 'Erreur') || str_starts_with($response, 'Désolé')) {
                    throw new \Exception($response);
                }

                return [
                    'success' => true,
                    'content' => $response
                ];

            } catch (\Exception $e) {
                Log::warning("Tentative AI #{$attempt} échouée", ['error' => $e->getMessage()]);
                
                if ($attempt >= $maxRetries) {
                    return [
                        'success' => false,
                        'error' => $e->getMessage()
                    ];
                }
                
                // Attendre avant retry (backoff exponentiel)
                usleep(500000 * $attempt); // 0.5s, 1s
            }
        }

        return ['success' => false, 'error' => 'Max retries atteint'];
    }

    /**
     * Sauvegarder la conversation en base
     */
    private function saveConversation($user, array $validated, string $response): AIConversation
    {
        try {
            $conversation = AIConversation::create([
                'user_id' => $user->id,
                'lesson_id' => $validated['lesson_id'] ?? null,
                'context' => $validated['context'],
                'user_message' => $validated['message'],
                'ai_response' => $response,
                'metadata' => [
                    'tokens_used' => $this->estimateTokens($validated['message'] . $response),
                    'model' => 'deepseek-chat',
                    'ip' => request()->ip(),
                    'user_agent' => Str::limit(request()->userAgent(), 200),
                ],
            ]);

            Log::info('Conversation sauvegardée', ['id' => $conversation->id]);
            
            return $conversation;

        } catch (\Exception $e) {
            Log::error('Erreur sauvegarde conversation', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    /**
     * Estimation des tokens
     */
    private function estimateTokens(string $text): int
    {
        // Approximation: ~4 caractères par token pour français
        return (int) ceil(mb_strlen($text) / 4);
    }

    /**
     * Méthode pour les questions depuis une leçon (API JSON)
     */
    public function askFromLesson(Request $request, $lessonId)
    {
        Log::info('Ask from lesson', ['lesson_id' => $lessonId, 'user_id' => Auth::id()]);

        try {
            $validated = $request->validate([
                'question' => 'required|string|max:1000',
            ]);

            $user = Auth::user();
            $lesson = Lesson::findOrFail($lessonId);

            $context = [
                'lesson_title' => $lesson->title,
                'lesson_content' => Str::limit($lesson->content, 1000),
                'user_level' => $user->profile->assessedLevel?->name,
            ];

            $response = $this->aiService->ask($validated['question'], $context);

            $conversation = AIConversation::create([
                'user_id' => $user->id,
                'lesson_id' => $lesson->id,
                'context' => 'lesson_help',
                'user_message' => $validated['question'],
                'ai_response' => $response,
            ]);

            return response()->json([
                'success' => true,
                'response' => $response,
                'conversation_id' => $conversation->id,
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur askFromLesson', [
                'lesson_id' => $lessonId,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur: ' . $e->getMessage()
            ], 500);
        }
    }
}