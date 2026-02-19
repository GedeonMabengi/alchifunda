<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenRouterService
{
    private string $apiKey;
    private string $model;
    private string $baseUrl;

    private ?string $siteUrl;
    private ?string $appName;

    public function __construct()
    {
        $this->apiKey  = (string) env('OPENROUTER_API_KEY');
        $this->model   = (string) env('OPENROUTER_MODEL', 'openrouter/free');
        $this->baseUrl = (string) env('OPENROUTER_BASE_URL', 'https://openrouter.ai/api/v1/chat/completions');

        $this->siteUrl = env('OPENROUTER_SITE_URL');
        $this->appName = env('OPENROUTER_APP_NAME');

        if (trim($this->apiKey) === '') {
            throw new \Exception('OPENROUTER_API_KEY non configurée dans .env');
        }
    }

    /**
     * Analyse multimodale : texte + fichiers (images, PDF, audio, vidéo, docs)
     * - Images => image_url (data URL base64)
     * - Audio  => input_audio (base64 raw + format)
     * - Vidéo  => video_url (data URL base64)
     * - PDF/Docs => file (file_data en data URL base64)
     *
     * Retourne le texte de la réponse.
     */
    public function analyzeMultimodal(string $text, array $files = [], array $context = []): string
    {
        $prompt = $this->buildPrompt($text, $context);

        // ✅ OpenRouter multimodal: messages[].content[] (array de blocs)
        $contentBlocks = [
            [
                'type' => 'text',
                'text' => $prompt,
            ],
        ];

        $hasPdf = false;
        $filesCount = 0;

        foreach ($files as $file) {
            $mime = $file['mime_type'] ?? 'application/octet-stream';
            $b64  = $file['data'] ?? null; // base64 raw
            $name = $file['filename'] ?? 'attachment';

            if (!$b64) {
                continue;
            }

            $filesCount++;

            // Images
            if (str_starts_with($mime, 'image/')) {
                $dataUrl = "data:{$mime};base64,{$b64}";
                $contentBlocks[] = [
                    'type' => 'image_url',
                    'image_url' => ['url' => $dataUrl],
                ];
                continue;
            }

            // Audio
            if (str_starts_with($mime, 'audio/')) {
                $format = $this->guessAudioFormat($mime, $name);
                $contentBlocks[] = [
                    'type' => 'input_audio',
                    'input_audio' => [
                        'data' => $b64,
                        'format' => $format,
                    ],
                ];
                continue;
            }

            // Vidéo
            if (str_starts_with($mime, 'video/')) {
                $dataUrl = "data:{$mime};base64,{$b64}";
                $contentBlocks[] = [
                    'type' => 'video_url',
                    'video_url' => ['url' => $dataUrl],
                ];
                continue;
            }

            // PDF / Docs / autres => file
            $dataUrl = "data:{$mime};base64,{$b64}";
            $contentBlocks[] = [
                'type' => 'file',
                'file' => [
                    'filename' => $name,
                    'file_data' => $dataUrl,
                ],
            ];

            if ($mime === 'application/pdf') {
                $hasPdf = true;
            }
        }

        $payload = [
            'model' => $this->model,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $contentBlocks,
                ],
            ],
            'max_tokens' => (int) env('OPENROUTER_MAX_TOKENS', 1200),
            'temperature' => (float) env('OPENROUTER_TEMPERATURE', 0.2),
            'stream' => false,
        ];

        // ✅ Plugin PDF parser (utile si le modèle choisi ne lit pas bien le PDF)
        // Engine gratuit: pdf-text
        if ($hasPdf && env('OPENROUTER_ENABLE_PDF_PARSER', true)) {
            $payload['plugins'] = [
                [
                    'id' => 'file-parser',
                    'pdf' => [
                        'engine' => env('OPENROUTER_PDF_ENGINE', 'pdf-text'),
                    ],
                ],
            ];
        }

        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer {$this->apiKey}",
        ];

        // Headers recommandés (facultatifs)
        if (!empty($this->siteUrl)) {
            $headers['HTTP-Referer'] = $this->siteUrl;
        }
        if (!empty($this->appName)) {
            $headers['X-Title'] = $this->appName;
        }

        Log::info('OpenRouterService: sending request', [
            'model' => $this->model,
            'base_url' => $this->baseUrl,
            'prompt_len' => strlen($prompt),
            'files_count' => $filesCount,
            'has_pdf' => $hasPdf,
            'temperature' => $payload['temperature'],
            'max_tokens' => $payload['max_tokens'],
        ]);

        try {
            $response = Http::timeout((int) env('OPENROUTER_TIMEOUT', 120))
                ->withHeaders($headers)
                ->post($this->baseUrl, $payload);

            if ($response->failed()) {
                Log::error('OpenRouterService: API error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                if ($response->status() === 401) {
                    throw new \Exception("OpenRouter 401: clé API invalide ou non autorisée.");
                }
                if ($response->status() === 429) {
                    throw new \Exception("OpenRouter 429: quota/rate limit atteint. Réessaie plus tard.");
                }

                throw new \Exception("Erreur API OpenRouter: {$response->status()}");
            }

            $data = $response->json();

            // ✅ OpenAI-compatible: choices[0].message.content
            $contentOut = $data['choices'][0]['message']['content'] ?? null;

            $final = '';

            // content peut être string OU array de blocs
            if (is_array($contentOut)) {
                $texts = [];
                foreach ($contentOut as $part) {
                    if (($part['type'] ?? null) === 'text' && !empty($part['text'])) {
                        $texts[] = $part['text'];
                    }
                }
                $final = trim(implode("\n\n", $texts));
            } else {
                $final = trim((string) $contentOut);
            }

            if ($final === '') {
                Log::warning('OpenRouterService: empty response', [
                    'raw' => $data,
                ]);
                throw new \Exception('Réponse vide de OpenRouter');
            }

            Log::info('OpenRouterService: success', [
                'model' => $this->model,
                'response_len' => strlen($final),
                'usage' => $data['usage'] ?? null,
            ]);

            return $final;

        } catch (\Throwable $e) {
            Log::error('OpenRouterService: exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    private function guessAudioFormat(string $mime, string $filename): string
    {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if ($ext) return $ext;

        return match ($mime) {
            'audio/mpeg', 'audio/mp3' => 'mp3',
            'audio/wav' => 'wav',
            'audio/ogg' => 'ogg',
            'audio/aac' => 'aac',
            default => 'wav',
        };
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
