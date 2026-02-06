<?php
// app/Http/Controllers/Assessment/InitialAssessmentController.php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\InitialAssessmentQuestion;
use App\Models\UserInitialAssessment;
use App\Models\UserProfile;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InitialAssessmentController extends Controller
{
    protected $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function start()
    {
        $user = Auth::user();
        
        if ($user->initial_assessment_completed) {
            return redirect()->route('dashboard');
        }

        return view('assessment.initial.start');
    }

    public function profileStep()
    {
        $levels = Level::where('is_active', true)->orderBy('order')->get();
        
        return view('assessment.initial.profile', compact('levels'));
    }

    public function saveProfile(Request $request)
    {
        $validated = $request->validate([
            'age' => 'required|integer|min:10|max:100',
            'declared_level_id' => 'required|exists:levels,id',
            'school_option' => 'required|string',
            'study_time_per_day' => 'required|integer|min:10|max:480',
            'study_days_per_week' => 'required|integer|min:1|max:7',
            'school_name' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $user->profile->update($validated);

        return redirect()->route('initial-assessment.knowledge');
    }

    public function knowledgeStep()
    {
        $user = Auth::user();
        $declaredLevel = $user->profile->declaredLevel;

        // Récupérer les questions adaptées au niveau déclaré et en dessous
        $questions = InitialAssessmentQuestion::where('is_active', true)
            ->where(function ($query) use ($declaredLevel) {
                $query->whereNull('level_id')
                    ->orWhereHas('level', function ($q) use ($declaredLevel) {
                        $q->where('order', '<=', $declaredLevel->order);
                    });
            })
            ->orderBy('difficulty_score')
            ->orderBy('order')
            ->take(10)
            ->get();

        return view('assessment.initial.knowledge', compact('questions'));
    }

    public function saveKnowledge(Request $request)
    {
        $user = Auth::user();
        $answers = $request->input('answers', []);
        
        $questions = InitialAssessmentQuestion::whereIn('id', array_keys($answers))->get();
        
        $totalScore = 0;
        $topicScores = [];
        $responses = [];

        foreach ($questions as $question) {
            $userAnswer = $answers[$question->id] ?? null;
            $isCorrect = $this->checkAnswer($question, $userAnswer);
            
            $responses[$question->id] = [
                'answer' => $userAnswer,
                'correct' => $isCorrect,
                'topic' => $question->topic,
            ];

            if ($isCorrect) {
                $totalScore += $question->difficulty_score;
            }

            // Calculer les scores par sujet
            if ($question->topic) {
                if (!isset($topicScores[$question->topic])) {
                    $topicScores[$question->topic] = ['correct' => 0, 'total' => 0];
                }
                $topicScores[$question->topic]['total']++;
                if ($isCorrect) {
                    $topicScores[$question->topic]['correct']++;
                }
            }
        }

        // Déterminer le niveau recommandé
        $recommendedLevel = $this->determineLevel($totalScore, $questions->count());

        // Analyse par l'IA
        $aiAnalysis = $this->aiService->analyzeInitialAssessment($responses, $topicScores, $user->profile);

        // Sauvegarder le résultat
        UserInitialAssessment::create([
            'user_id' => $user->id,
            'responses' => $responses,
            'total_score' => $totalScore,
            'recommended_level_id' => $recommendedLevel->id,
            'topic_scores' => $topicScores,
            'ai_analysis' => $aiAnalysis,
            'completed_at' => now(),
        ]);

        // Mettre à jour le profil
        $user->profile->update(['assessed_level_id' => $recommendedLevel->id]);

        return redirect()->route('initial-assessment.preferences');
    }

    public function preferencesStep()
    {
        return view('assessment.initial.preferences');
    }

    public function savePreferences(Request $request)
    {
        $validated = $request->validate([
            'tone' => 'required|in:formal,casual,friendly',
            'detail_level' => 'required|in:concise,moderate,detailed',
            'example_style' => 'required|in:everyday,scientific,mixed',
            'show_math_steps' => 'boolean',
            'preferred_study_time' => 'nullable|date_format:H:i',
        ]);

        $user = Auth::user();
        $user->preferences->update($validated);
        $user->update(['initial_assessment_completed' => true]);

        return redirect()->route('initial-assessment.complete');
    }

    public function complete()
    {
        $user = Auth::user();
        $assessment = UserInitialAssessment::where('user_id', $user->id)
            ->latest()
            ->first();

        $recommendedLevel = $assessment->recommendedLevel;

        return view('assessment.initial.complete', compact('assessment', 'recommendedLevel'));
    }

    private function checkAnswer($question, $userAnswer)
    {
        if ($userAnswer === null) {
            return false;
        }

        $correctAnswer = strtolower(trim($question->correct_answer));
        $userAnswer = strtolower(trim($userAnswer));

        return $correctAnswer === $userAnswer;
    }

    private function determineLevel($score, $totalQuestions)
    {
        $percentage = ($score / ($totalQuestions * 5)) * 100; // Assuming max difficulty_score is 5

        if ($percentage >= 80) {
            return Level::where('code', '6HUM')->first();
        } elseif ($percentage >= 60) {
            return Level::where('code', '5HUM')->first();
        } elseif ($percentage >= 40) {
            return Level::where('code', '4SEC')->first();
        } else {
            return Level::where('code', '3SEC')->first();
        }
    }
}