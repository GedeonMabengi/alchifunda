<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIGroqService
class AIGroqService
{
    private string $apiKey;
    private string $apiUrl = 'https://api.groq.com/openai/v1/chat/completions';
    
    public function __construct()
    {
        $this->apiKey = env('GROQ_API_KEY'); // ou DEEPSEEK_API_KEY
        
        if (empty($this->apiKey)) {
            Log::error('GROQ_API_KEY non configurée');
            throw new \Exception('Clé API non configurée');
        }
    }
    
    public function ask(string $question, array $context = []): string
    {
        try {
            $messages = [
                [
                    'role' => 'system',
                    'content' => "Tu es un professeur de chimie expert pour le programme RDC secondaire. " .
                                 "Niveau élève: " . ($context['user_level'] ?? 'secondaire') . ". " .
                                 "Réponds de manière claire, pédagogique, avec exemples concrets. " .
                                 "Utilise du markdown pour structurer (titres, listes, gras)."
                ],
                [
                    'role' => 'user',
                    'content' => $question
                ]
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])
            ->timeout(60)
            ->post($this->apiUrl, [
                'model' => 'llama-3.1-8b-instant',
                // 'model' => 'mixtral-8x7b-32768', // Plus puissant
                'messages' => $messages,
                'max_tokens' => 2000,
                'temperature' => 0.7,
            ]);

            if ($response->failed()) {
                Log::error('Erreur Groq', ['status' => $response->status(), 'body' => $response->body()]);
                return "Erreur API ({$response->status()}). Réessayez.";
            }

            $data = $response->json();
            return $data['choices'][0]['message']['content'] ?? 'Pas de réponse';

        } catch (\Exception $e) {
            Log::error('Exception AIService', ['error' => $e->getMessage()]);
            return "Erreur: " . $e->getMessage();
        }
    }
    
    public function adaptContent($lesson, $preferences): string
    {
        return $this->ask("Adapte ce contenu: " . substr($lesson->content ?? '', 0, 1000), [
            'user_level' => $preferences['level'] ?? 'secondaire'
        ]);
    }
    
    public function answerQuestion(string $question, $lesson, $preferences): string
    {
        return $this->ask($question, [
            'user_level' => $preferences->detail_level ?? 'moderate',
            'lesson' => $lesson->title ?? ''
        ]);
    }
}