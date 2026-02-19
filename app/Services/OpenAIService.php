<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenAIService
{
    private string $apiKey;
    private string $model;
    private string $baseUrl = 'https://api.openai.com/v1/responses';

    public function __construct()
    {
        $this->apiKey = (string) env('OPENAI_API_KEY');
        $this->model = (string) env('OPENAI_MODEL', 'gpt-4o-mini');

        if (trim($this->apiKey) === '') {
            throw new \Exception('OPENAI_API_KEY non configurée dans .env');
        }
    }

    /**
     * Analyse multimodale : texte + fichiers (images, PDF, audio, vidéo, docs)
     * - Images: envoyées en input_image via data URL base64.
     * - PDF: envoyés en input_file (base64).
     * - Autres fichiers: envoyés en input_file (base64) (l’exploitation dépend du modèle).
     */
    public function analyzeMultimodal(string $text, array $files = [], array $context = []): string
    {
        $prompt = $this->buildPrompt($text, $context);

        // Items pour la Responses API
        $contentItems = [
            [
                'type' => 'input_text',
                'text' => $prompt,
            ],
        ];

        foreach ($files as $file) {
            $mime = $file['mime_type'] ?? 'application/octet-stream';
            $data = $file['data'] ?? null; // base64 (sans prefix)
            $name = $file['filename'] ?? 'attachment';

            if (!$data) {
                continue;
            }

            // Images -> input_image
            if (str_starts_with($mime, 'image/')) {
                $contentItems[] = [
                    'type' => 'input_image',
                    'image_url' => "data:{$mime};base64,{$data}",
                    // 'detail' => 'high', // optionnel
                ];
                continue;
            }

            // PDF -> input_file
            if ($mime === 'application/pdf') {
                $contentItems[] = [
                    'type' => 'input_file',
                    'filename' => $name,
                    'file_data' => $data, // base64 pur
                ];
                continue;
            }

            // Autres fichiers -> input_file (à tester selon besoins)
            $contentItems[] = [
                'type' => 'input_file',
                'filename' => $name,
                'file_data' => $data,
            ];
        }

        $payload = [
            'model' => $this->model,
            'input' => [
                [
                    'role' => 'user',
                    'content' => $contentItems,
                ],
            ],
            // Réglages de génération (ajuste si besoin)
            'max_output_tokens' => 1200,
        ];

        Log::info('OpenAIService: sending request', [
            'model' => $this->model,
            'has_files' => count($files) > 0,
            'files_count' => count($files),
            'prompt_len' => strlen($prompt),
        ]);

        try {
            $response = Http::timeout(120)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => "Bearer {$this->apiKey}",
                ])
                ->post($this->baseUrl, $payload);

            if ($response->failed()) {
                Log::error('OpenAIService: API error', [
                    'status' => $response->status(),
                    'headers' => $response->headers(),
                    'body' => $response->body(),
                ]);

                // Messages plus explicites
                if ($response->status() === 401) {
                    throw new \Exception("OpenAI 401: clé API invalide ou non autorisée.");
                }
                if ($response->status() === 429) {
                    throw new \Exception("OpenAI 429: quota/rate limit atteint. Réessaie dans quelques secondes.");
                }

                throw new \Exception("Erreur API OpenAI: {$response->status()}");
            }

            $data = $response->json();

            // Extraction du texte depuis output[].content[].text (Responses API)
            $output = $data['output'] ?? [];
            $texts = [];

            foreach ($output as $item) {
                $parts = $item['content'] ?? [];
                foreach ($parts as $part) {
                    if (($part['type'] ?? null) === 'output_text' && !empty($part['text'])) {
                        $texts[] = $part['text'];
                    }
                }
            }

            $final = trim(implode("\n\n", $texts));

            // Fallback éventuel (si format différent)
            if ($final === '' && isset($data['output_text'])) {
                $final = trim((string) $data['output_text']);
            }

            if ($final === '') {
                Log::warning('OpenAIService: empty response', [
                    'raw' => $data,
                ]);
                throw new \Exception('Réponse vide de OpenAI');
            }

            Log::info('OpenAIService: success', [
                'model' => $this->model,
                'response_len' => strlen($final),
            ]);

            return $final;

        } catch (\Throwable $e) {
            Log::error('OpenAIService: exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
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

        if (isset($context['subject'])) {
            $system .= "Matière: {$context['subject']}. ";
        }

        $system .= "Réponds de manière claire, pédagogique et structurée. ";
        $system .= "Si des fichiers sont joints (images, PDF, audio, vidéo, etc.), analyse-les en détail et réponds en français.\n\n";
        $system .= "Question ou consigne: {$question}";

        return $system;
    }
}
