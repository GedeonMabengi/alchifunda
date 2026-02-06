<?php
// app/Http/Controllers/Learning/LevelController.php

namespace App\Http\Controllers\Learning;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Chapter;
use App\Models\UserLessonProgress;
use Illuminate\Support\Facades\Auth;

class LevelController extends Controller
{
    public function index()
    {
        $levels = Level::where('is_active', true)
            ->withCount('chapters')
            ->orderBy('order')
            ->get();

        $user = Auth::user();
        $currentLevel = $user->profile->assessedLevel ?? $user->profile->declaredLevel;

        return view('learning.level.index', compact('levels', 'currentLevel'));
    }

    public function show($code)
    {
        $level = Level::where('code', $code)
            ->with(['chapters' => function ($query) {
                $query->where('is_active', true)
                    ->withCount('lessons')
                    ->orderBy('order');
            }])
            ->firstOrFail();

        $user = Auth::user();

        // Calculer la progression pour chaque chapitre
        $level->chapters->each(function ($chapter) use ($user) {
            $lessonIds = $chapter->lessons->pluck('id');
            $completedCount = UserLessonProgress::where('user_id', $user->id)
                ->whereIn('lesson_id', $lessonIds)
                ->where('status', 'completed')
                ->count();

            $chapter->progress_percentage = $chapter->lessons_count > 0
                ? round(($completedCount / $chapter->lessons_count) * 100)
                : 0;
        });

        return view('learning.level.show', compact('level'));
    }
}