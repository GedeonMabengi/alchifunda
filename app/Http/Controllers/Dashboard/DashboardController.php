<?php
// app/Http/Controllers/Dashboard/DashboardController.php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Lesson;
use App\Models\UserLessonProgress;
use App\Models\UserAssessmentResult;
use App\Models\Achievement;
use App\Models\UserAchievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $preferences = $user->preferences;

        // Récupérer le niveau actuel
        $currentLevel = $profile->assessedLevel ?? $profile->declaredLevel;

        // Leçons recommandées
        $recommendedLessons = $this->getRecommendedLessons($user, $currentLevel);

        // Progression globale
        $progressStats = $this->getProgressStats($user);

        // Dernières activités
        $recentActivity = UserLessonProgress::where('user_id', $user->id)
            ->with('lesson.chapter')
            ->orderBy('last_accessed_at', 'desc')
            ->take(5)
            ->get();

        // Récompenses récentes
        $recentAchievements = UserAchievement::where('user_id', $user->id)
            ->with('achievement')
            ->orderBy('earned_at', 'desc')
            ->take(3)
            ->get();

        // Objectifs de la semaine
        $weeklyGoals = $this->getWeeklyGoals($user);

        return view('dashboard.index', compact(
            'user',
            'profile',
            'preferences',
            'currentLevel',
            'recommendedLessons',
            'progressStats',
            'recentActivity',
            'recentAchievements',
            'weeklyGoals'
        ));
    }

    private function getRecommendedLessons($user, $level)
    {
        if (!$level) {
            return collect();
        }

        $completedLessonIds = UserLessonProgress::where('user_id', $user->id)
            ->where('status', 'completed')
            ->pluck('lesson_id');

        return Lesson::whereHas('chapter', function ($query) use ($level) {
                $query->where('level_id', $level->id);
            })
            ->whereNotIn('id', $completedLessonIds)
            ->orderBy('chapter_id')
            ->orderBy('order')
            ->take(5)
            ->with('chapter')
            ->get();
    }

    private function getProgressStats($user)
    {
        $totalLessons = Lesson::where('is_active', true)->count();
        $completedLessons = UserLessonProgress::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $totalAssessments = UserAssessmentResult::where('user_id', $user->id)->count();
        $passedAssessments = UserAssessmentResult::where('user_id', $user->id)
            ->where('passed', true)
            ->count();

        return [
            'total_lessons' => $totalLessons,
            'completed_lessons' => $completedLessons,
            'completion_percentage' => $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0,
            'total_assessments' => $totalAssessments,
            'passed_assessments' => $passedAssessments,
            'average_score' => UserAssessmentResult::where('user_id', $user->id)->avg('percentage') ?? 0,
            'current_streak' => $user->profile->current_streak_days ?? 0,
        ];
    }

    private function getWeeklyGoals($user)
    {
        $profile = $user->profile;
        $targetLessonsPerWeek = ceil(($profile->study_time_per_day ?? 30) * ($profile->study_days_per_week ?? 5) / 30);

        $lessonsThisWeek = UserLessonProgress::where('user_id', $user->id)
            ->where('status', 'completed')
            ->where('completed_at', '>=', now()->startOfWeek())
            ->count();

        return [
            'target_lessons' => $targetLessonsPerWeek,
            'completed_lessons' => $lessonsThisWeek,
            'progress_percentage' => $targetLessonsPerWeek > 0 ? min(100, round(($lessonsThisWeek / $targetLessonsPerWeek) * 100)) : 0,
        ];
    }
}