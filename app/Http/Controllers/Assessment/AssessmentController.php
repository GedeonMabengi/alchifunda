<?php
// app/Http/Controllers/Assessment/AssessmentController.php

namespace App\Http\Controllers\Assessment;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Question;
use App\Models\UserAssessmentResult;
use App\Models\UserQuestionAnswer;
use App\Models\UserLessonProgress;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssessmentController extends Controller
{
    protected $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function start($assessmentId)
    {
        $assessment = Assessment::with(['lesson.chapter', 'questions'])
            ->findOrFail($assessmentId);

        $user = Auth::user();

        // Vérifier le nombre de tentatives
        $attempts = UserAssessmentResult::where('user_id', $user->id)
            ->where('assessment_id', $assessment->id)
            ->count();

        if ($attempts >= $assessment->max_attempts) {
            return redirect()->back()
                ->with('error', 'Vous avez atteint le nombre maximum de tentatives.');
        }

        // Préparer les questions (mélanger si nécessaire)
        $questions = $assessment->questions;
        if ($assessment->shuffle_questions) {
            $questions = $questions->shuffle();
        }

        return view('assessment.start', compact('assessment', 'questions', 'attempts'));
    }

    public function submit(Request $request, $assessmentId)
    {
        $assessment = Assessment::with('questions')->findOrFail($assessmentId);
        $user = Auth::user();
        $answers = $request->input('answers', []);
        $startedAt = $request->input('started_at');

        $attemptNumber = UserAssessmentResult::where('user_id', $user->id)
            ->where('assessment_id', $assessment->id)
            ->count() + 1;

        DB::beginTransaction();

        try {
            $totalPoints = 0;
            $earnedPoints = 0;
            $questionResults = [];
            $weakPoints = [];
            $strongPoints = [];

            // Évaluer chaque question
            foreach ($assessment->questions as $question) {
                $userAnswer = $answers[$question->id] ?? null;
                $isCorrect = $this->evaluateAnswer($question, $userAnswer);
                
                $pointsEarned = $isCorrect ? $question->points : 0;
                $earnedPoints += $pointsEarned;
                $totalPoints += $question->points;

                $questionResults[$question->id] = [
                    'answer' => $userAnswer,
                    'correct' => $isCorrect,
                    'points' => $pointsEarned,
                ];

                // Identifier forces et faiblesses
                if ($isCorrect) {
                    $strongPoints[] = $question->id;
                } else {
                    $weakPoints[] = $question->id;
                }
            }

            $percentage = $totalPoints > 0 ? round(($earnedPoints / $totalPoints) * 100) : 0;
            $passed = $percentage >= $assessment->passing_score;

            // Générer le feedback IA
            $aiFeedback = $this->aiService->generateAssessmentFeedback(
                $assessment,
                $questionResults,
                $percentage,
                $user->preferences
            );

            // Créer le résultat
            $result = UserAssessmentResult::create([
                'user_id' => $user->id,
                'assessment_id' => $assessment->id,
                'score' => $earnedPoints,
                'percentage' => $percentage,
                'passed' => $passed,
                'attempt_number' => $attemptNumber,
                'time_taken_minutes' => $startedAt ? now()->diffInMinutes($startedAt) : null,
                'answers' => $questionResults,
                'ai_feedback' => $aiFeedback,
                'weak_points' => $weakPoints,
                'strong_points' => $strongPoints,
                'started_at' => $startedAt ?? now(),
                'completed_at' => now(),
            ]);

            // Sauvegarder les réponses détaillées
            foreach ($assessment->questions as $question) {
                $questionResult = $questionResults[$question->id];
                
                UserQuestionAnswer::create([
                    'user_id' => $user->id,
                    'user_assessment_result_id' => $result->id,
                    'question_id' => $question->id,
                    'user_answer' => $questionResult['answer'],
                    'is_correct' => $questionResult['correct'],
                    'points_earned' => $questionResult['points'],
                    'ai_explanation' => $this->aiService->explainAnswer($question, $questionResult['answer'], $user->preferences),
                ]);
            }

            // Mettre à jour la progression de la leçon si réussi
            if ($passed) {
                $user->profile->increment('total_assessments_passed');
                
                if ($assessment->lesson) {
                    UserLessonProgress::where('user_id', $user->id)
                        ->where('lesson_id', $assessment->lesson_id)
                        ->update(['status' => 'completed']);
                }
            } else {
                // Marquer pour révision
                if ($assessment->lesson) {
                    UserLessonProgress::where('user_id', $user->id)
                        ->where('lesson_id', $assessment->lesson_id)
                        ->update(['status' => 'revision_needed']);
                }
            }

            DB::commit();

            return redirect()->route('assessment.result', $result->id);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function result($resultId)
    {
        $result = UserAssessmentResult::with([
            'assessment.lesson.chapter',
            'assessment.questions',
            'questionAnswers.question'
        ])->findOrFail($resultId);

        $this->authorize('view', $result);

        return view('assessment.result', compact('result'));
    }

    public function retry($assessmentId)
    {
        return redirect()->route('assessment.start', $assessmentId);
    }

    private function evaluateAnswer(Question $question, $userAnswer)
    {
        if ($userAnswer === null) {
            return false;
        }

        $correctAnswer = strtolower(trim($question->correct_answer));
        $userAnswer = strtolower(trim($userAnswer));

        switch ($question->question_type) {
            case 'mcq':
            case 'true_false':
                return $correctAnswer === $userAnswer;
            
            case 'short_answer':
                // Comparaison plus flexible pour les réponses courtes
                return similar_text($correctAnswer, $userAnswer) / max(strlen($correctAnswer), strlen($userAnswer)) > 0.8;
            
            case 'calculation':
                // Pour les calculs, comparer les valeurs numériques
                return abs(floatval($correctAnswer) - floatval($userAnswer)) < 0.01;
            
            case 'fill_blank':
                return $correctAnswer === $userAnswer;
            
            default:
                return $correctAnswer === $userAnswer;
        }
    }
}