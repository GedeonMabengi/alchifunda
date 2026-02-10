<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AITestController extends Controller
{
    public function index()
    {
        return view('ai-test');
    }
    
    public function ask(Request $request)
    {
        // Log de la requête entrante - VERSION CORRIGÉE
        Log::info('=== AI ASK GENERAL DÉMARRÉ ===', [
            'user_id' => auth()->id() ?? 'guest',
            'ip' => $request->ip(),
            'input' => $request->all() // Log tout ce qui arrive
        ]);
        
        // VALIDATION CORRIGÉE - Utilisez les bons noms de champs
        $validated = $request->validate([
            'question' => 'required|string|max:2000', // "question" pas "message"
            'temperature' => 'nullable|numeric|min:0|max:2',
            'max_tokens' => 'nullable|integer|min:50|max:4000',
            // 'context' n'est pas obligatoire pour le test simple
        ]);
        
        Log::info('Validation réussie', ['data' => $validated]);
        
        $apiKey = env('DEEPSEEK_API_KEY');
        
        // Log de la configuration
        Log::debug('Configuration API', [
            'api_key_exists' => !empty($apiKey),
            'api_key_prefix' => $apiKey ? substr($apiKey, 0, 12) . '...' : 'NULL',
        ]);
        
        if (!$apiKey || $apiKey === 'sk_votre_cle_api_ici') {
            Log::error('Clé API manquante ou par défaut');
            
            return response()->json([
                'success' => false,
                'error' => 'Configuration manquante',
                'message' => 'Clé API non configurée ou encore sur la valeur par défaut',
                'hint' => 'Vérifiez votre fichier .env : DEEPSEEK_API_KEY=sk_votre_vraie_clé'
            ], 500);
        }
        
        // Vérifier le format de la clé API
        if (!str_starts_with($apiKey, 'sk_')) {
            Log::warning('Format de clé API invalide', [
                'key_prefix' => substr($apiKey, 0, 20)
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Clé API invalide',
                'message' => 'La clé API doit commencer par "sk_"',
                'your_key_start' => substr($apiKey, 0, 20)
            ], 500);
        }
        
        try {
            // Payload simplifié pour test
            $payload = [
                'model' => 'deepseek-chat',
                'messages' => [
                    [
                        'role' => 'user', 
                        'content' => $validated['question']
                    ]
                ],
                'max_tokens' => $validated['max_tokens'] ?? 500,
                'temperature' => $validated['temperature'] ?? 0.7,
            ];
            
            Log::debug('Payload préparé', [
                'model' => 'deepseek-chat',
                'question_length' => strlen($validated['question']),
                'max_tokens' => $payload['max_tokens']
            ]);
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])
            ->timeout(30)
            ->post('https://api.deepseek.com/v1/chat/completions', $payload);
            
            Log::debug('Réponse HTTP brute', [
                'status' => $response->status(),
                'headers' => $response->headers()
            ]);
            
            if ($response->successful()) {
                $data = $response->json();
                
                Log::info('✅ Requête AI réussie', [
                    'model' => $data['model'] ?? 'unknown',
                    'tokens' => $data['usage']['total_tokens'] ?? 0,
                    'has_response' => isset($data['choices'][0]['message']['content'])
                ]);
                
                return response()->json([
                    'success' => true,
                    'response' => $data['choices'][0]['message']['content'] ?? 'Aucun contenu dans la réponse',
                    'usage' => $data['usage'] ?? [],
                    'model' => $data['model'] ?? 'deepseek-chat'
                ]);
                
            } else {
                $errorBody = $response->body();
                $errorJson = json_decode($errorBody, true);
                
                Log::error('❌ Erreur API', [
                    'status' => $response->status(),
                    'error_body' => $errorBody,
                    'error_json' => $errorJson
                ]);
                
                // Messages d'erreur courants
                $userMessage = 'Erreur de l\'API';
                $details = '';
                
                if ($response->status() === 401) {
                    $userMessage = 'Clé API invalide ou expirée';
                    $details = 'Vérifiez votre clé dans le fichier .env';
                } elseif ($response->status() === 429) {
                    $userMessage = 'Quota dépassé';
                    $details = 'Vous avez dépassé la limite de requêtes';
                } elseif (isset($errorJson['error']['message'])) {
                    $userMessage = $errorJson['error']['message'];
                }
                
                return response()->json([
                    'success' => false,
                    'error' => 'Erreur API',
                    'message' => $userMessage,
                    'details' => $details,
                    'status' => $response->status(),
                    'raw_error' => config('app.debug') ? $errorBody : null
                ], $response->status());
            }
            
        } catch (\Exception $e) {
            Log::error('💥 Exception', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Exception',
                'message' => 'Erreur interne: ' . $e->getMessage(),
                'hint' => 'Vérifiez votre connexion internet et la configuration'
            ], 500);
        }
    }
    
    /**
     * Route simple pour tester la connexion
     */
    public function testConnection()
    {
        $apiKey = env('DEEPSEEK_API_KEY');
        
        $testData = [
            'env_exists' => file_exists(base_path('.env')),
            'api_key_set' => !empty($apiKey),
            'api_key_format' => $apiKey ? (str_starts_with($apiKey, 'sk_') ? 'VALID' : 'INVALID') : 'MISSING',
            'app_env' => config('app.env'),
            'app_debug' => config('app.debug'),
        ];
        
        Log::info('Test de connexion', $testData);
        
        // Tester une requête simple
        if ($apiKey && str_starts_with($apiKey, 'sk_')) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $apiKey,
                ])
                ->timeout(10)
                ->get('https://api.deepseek.com/v1/models');
                
                $testData['api_test'] = $response->successful() ? 'CONNECTED' : 'ERROR: ' . $response->status();
                $testData['api_response'] = $response->successful() ? 'OK' : $response->body();
                
            } catch (\Exception $e) {
                $testData['api_test'] = 'EXCEPTION: ' . $e->getMessage();
            }
        }
        
        return response()->json([
            'success' => true,
            'test' => $testData,
            'timestamp' => now()->toDateTimeString(),
            'note' => 'Vérifiez les logs dans storage/logs/laravel.log'
        ]);
    }
}