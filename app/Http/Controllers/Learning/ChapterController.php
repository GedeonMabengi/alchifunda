<?php
// app/Http/Controllers/Learning/ChapterController.php

namespace App\Http\Controllers\Learning;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\UserLessonProgress;
use Illuminate\Support\Facades\Auth;

class ChapterController extends Controller
{
    public function index($levelCode = null)
    {
        $user = Auth::user();
        $currentLevel = $user->profile->assessedLevel ?? $user->profile->declaredLevel;

        $query = Chapter::with(['level', 'lessons'])
            ->where('is_active', true);

        if ($levelCode) {
            $query->whereHas('level', function ($q) use ($levelCode) {
                $q->where('code', $levelCode);
            });
        } elseif ($currentLevel) {
            $query->where('level_id', $currentLevel->id);
        }

        $chapters = $query->orderBy('order')->get();

        // Ajouter les infos de progression pour chaque chapitre
        $chapters->each(function ($chapter) use ($user) {
            $totalLessons = $chapter->lessons->count();
            $completedLessons = UserLessonProgress::where('user_id', $user->id)
                ->whereIn('lesson_id', $chapter->lessons->pluck('id'))
                ->where('status', 'completed')
                ->count();

            $chapter->progress_percentage = $totalLessons > 0 
                ? round(($completedLessons / $totalLessons) * 100) 
                : 0;
            $chapter->completed_lessons = $completedLessons;
            $chapter->total_lessons = $totalLessons;
        });

        return view('learning.chapter.index', compact('chapters', 'currentLevel'));
    }

    public function show($slug)
    {
        $chapter = Chapter::where('slug', $slug)
            ->with(['level', 'lessons' => function ($query) {
                $query->where('is_active', true)->orderBy('order');
            }])
            ->firstOrFail();

        $user = Auth::user();

        // Ajouter les infos de progression pour chaque leçon
        $chapter->lessons->each(function ($lesson) use ($user) {
            $progress = UserLessonProgress::where('user_id', $user->id)
                ->where('lesson_id', $lesson->id)
                ->first();

            $lesson->user_status = $progress->status ?? 'not_started';
            $lesson->user_progress = $progress->progress_percentage ?? 0;
        });

        // Chapitres adjacents
        $previousChapter = Chapter::where('level_id', $chapter->level_id)
            ->where('order', '<', $chapter->order)
            ->orderBy('order', 'desc')
            ->first();

        $nextChapter = Chapter::where('level_id', $chapter->level_id)
            ->where('order', '>', $chapter->order)
            ->orderBy('order')
            ->first();

        return view('learning.chapter.show', compact('chapter', 'previousChapter', 'nextChapter'));
    }
}