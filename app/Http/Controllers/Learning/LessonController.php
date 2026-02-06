<?php
// app/Http/Controllers/Learning/LessonController.php

namespace App\Http\Controllers\Learning;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\Assessment;
use App\Models\UserLessonProgress;
use App\Models\StudySession;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    protected $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function showX($chapterSlug, $lessonSlug)
    {
        $lesson = Lesson::where('slug', $lessonSlug)
            ->whereHas('chapter', function ($query) use ($chapterSlug) {
                $query->where('slug', $chapterSlug);
            })
            ->with(['chapter.level', 'assessments'])
            ->firstOrFail();

        $user = Auth::user();

        // Vérifier/créer la progression
        $progress = UserLessonProgress::firstOrCreate(
            ['user_id' => $user->id, 'lesson_id' => $lesson->id],
            [
                'status' => 'in_progress',
                'started_at' => now(),
                'last_accessed_at' => now(),
            ]
        );

        // Mettre à jour l'accès
        $progress->update([
            'last_accessed_at' => now(),
            'access_count' => $progress->access_count + 1,
        ]);

        // Adapter le contenu selon les préférences
        $preferences = $user->preferences;
        $adaptedContent = $this->aiService->adaptContent($lesson, $preferences);

        // Mini-quiz intégrés
        $miniQuiz = Assessment::where('lesson_id', $lesson->id)
            ->where('type', 'mini_quiz')
            ->with('questions')
            ->first();

        // Leçons adjacentes
        $previousLesson = Lesson::where('chapter_id', $lesson->chapter_id)
            ->where('order', '<', $lesson->order)
            ->orderBy('order', 'desc')
            ->first();

        $nextLesson = Lesson::where('chapter_id', $lesson->chapter_id)
            ->where('order', '>', $lesson->order)
            ->orderBy('order')
            ->first();

        return view('learning.lesson.show', compact(
            'lesson',
            'progress',
            'adaptedContent',
            'miniQuiz',
            'previousLesson',
            'nextLesson'
        ));
    }

    public function show($chapterSlug, $lessonSlug)
{
    $lesson = Lesson::where('slug', $lessonSlug)
        ->whereHas('chapter', function ($query) use ($chapterSlug) {
            $query->where('slug', $chapterSlug);
        })
        ->with(['chapter.level', 'assessments'])
        ->firstOrFail();

    $user = Auth::user();
    
    // Récupérer le niveau via la relation
    $level = $lesson->chapter->level;

    // Vérifier/créer la progression
    $progress = UserLessonProgress::firstOrCreate(
        ['user_id' => $user->id, 'lesson_id' => $lesson->id],
        [
            'status' => 'in_progress',
            'started_at' => now(),
            'last_accessed_at' => now(),
        ]
    );

    // Mettre à jour l'accès
    $progress->update([
        'last_accessed_at' => now(),
        'access_count' => $progress->access_count + 1,
    ]);

    // Adapter le contenu selon les préférences
    $preferences = $user->preferences;
    $adaptedContent = $this->aiService->adaptContent($lesson, $preferences);

    // Mini-quiz intégrés
    $miniQuiz = Assessment::where('lesson_id', $lesson->id)
        ->where('type', 'mini_quiz')
        ->with('questions')
        ->first();

    // Leçons adjacentes
    $previousLesson = Lesson::where('chapter_id', $lesson->chapter_id)
        ->where('order', '<', $lesson->order)
        ->orderBy('order', 'desc')
        ->first();

    $nextLesson = Lesson::where('chapter_id', $lesson->chapter_id)
        ->where('order', '>', $lesson->order)
        ->orderBy('order')
        ->first();

    return view('learning.lesson.show', compact(
        'lesson',
        'level',
        'progress',
        'adaptedContent',
        'miniQuiz',
        'previousLesson',
        'nextLesson'
    ));
}

    public function complete(Request $request, $lessonId)
    {
        $user = Auth::user();
        $lesson = Lesson::findOrFail($lessonId);

        $progress = UserLessonProgress::where('user_id', $user->id)
            ->where('lesson_id', $lesson->id)
            ->first();

        if ($progress) {
            $progress->update([
                'status' => 'completed',
                'progress_percentage' => 100,
                'completed_at' => now(),
            ]);

            // Mettre à jour les stats du profil
            $user->profile->increment('total_lessons_completed');
            
            // Vérifier les achievements
            $this->checkAchievements($user);
        }

        // Rediriger vers le contrôle de fin de leçon
        $endControl = Assessment::where('lesson_id', $lesson->id)
            ->where('type', 'end_lesson_control')
            ->first();

        if ($endControl) {
            return redirect()->route('assessment.start', $endControl->id);
        }

        return redirect()->route('chapter.show', $lesson->chapter->slug)
            ->with('success', 'Leçon terminée avec succès !');
    }

    public function askAI(Request $request, $lessonId)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:1000',
        ]);

        $user = Auth::user();
        $lesson = Lesson::findOrFail($lessonId);

        $response = $this->aiService->answerQuestion(
            $validated['question'],
            $lesson,
            $user->preferences
        );

        // Sauvegarder la conversation
        $user->aiConversations()->create([
            'lesson_id' => $lesson->id,
            'context' => 'lesson_help',
            'user_message' => $validated['question'],
            'ai_response' => $response,
        ]);

        return response()->json([
            'success' => true,
            'response' => $response,
        ]);
    }

    private function checkAchievements($user)
    {
        // Logique de vérification des achievements
        // (implémentation détaillée dans AchievementService)
    }

    public function index()
    {
        $lessons = Lesson::where('is_active', true)
            ->with('chapter') // charger le chapitre
            ->orderBy('chapter_id')
            ->orderBy('order')
            ->get();

        return view('learning.lesson.index', compact('lessons'));
    }
}