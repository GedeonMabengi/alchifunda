<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    private string $apiKey;
    private string $baseUrl = 'https://generativelanguage.googleapis.com/v1/models';
    // private string $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=t';

    
    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
        
        if (empty($this->apiKey)) {
            throw new \Exception('GEMINI_API_KEY non configurée dans .env');
        }
    }

    /**
     * Analyse multimodale : texte + fichiers (images, PDF, audio, vidéo)
     */
    public function analyzeMultimodal(string $text, array $files = [], array $context = []): string
    {
        // Utilisation du nom stable (sans -latest si possible)
        $model = 'gemini-1.5-flash'; // À ajuster selon les modèles disponibles et stables au moment du développement
    
        // CORRECTION : L'URL ne doit pas avoir "models/" en double ou manquant.
        // Votre baseUrl finit déjà par /models, donc on ajoute juste le nom du modèle.
        $url = "{$this->baseUrl}/{$model}:generateContent?key={$this->apiKey}";
        
        // Construction des parts (texte + fichiers)
        $parts = [['text' => $this->buildPrompt($text, $context)]];
        
        foreach ($files as $file) {
            $parts[] = [
                'inline_data' => [
                    'mime_type' => $file['mime_type'],
                    'data' => $file['data'],
                ]
            ];
        }

        $payload = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => $parts,
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 8192,
                'topP' => 0.8,
                'topK' => 40,
            ],
            'safetySettings' => [
                [
                    'category' => 'HARM_CATEGORY_HARASSMENT',
                    'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                ],
                [
                    'category' => 'HARM_CATEGORY_HATE_SPEECH',
                    'threshold' => 'BLOCK_MEDIUM_AND_ABOVE'
                ],
            ],
        ];

        try {
            $response = Http::timeout(120)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post($url, $payload);

            if ($response->failed()) {
                Log::error('Erreur Gemini API', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
                throw new \Exception("Erreur API Gemini: {$response->status()}");
            }

            $data = $response->json();
            $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
            
            if (!$text) {
                throw new \Exception('Réponse vide de Gemini');
            }

            return $text;

        } catch (\Exception $e) {
            Log::error('Exception GeminiService', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    private function buildPrompt(string $question, array $context): string
    {
        $system = "Tu es un professeur de chimie expert spécialisé dans le programme de la RDC (République Démocratique du Congo). ";
        $system .= "Tu aides des élèves du secondaire. ";
        
        if (isset($context['user_level'])) {
            $system .= "Niveau de l'élève: {$context['user_level']}. ";
        }
        
        $system .= "Réponds de manière claire, pédagogique et structurée. ";
        $system .= "Si des fichiers sont joints (images, PDF, etc.), analyse-les en détail et réponds en français.\n\n";
        $system .= "Question ou consigne: {$question}";
        
        return $system;
    }
}