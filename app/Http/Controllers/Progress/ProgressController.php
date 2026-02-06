<?php
// app/Http/Controllers/Progress/ProgressController.php

namespace App\Http\Controllers\Progress;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Chapter;
use App\Models\UserLessonProgress;
use App\Models\UserAssessmentResult;
use App\Models\StudySession;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ProgressController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Progression par niveau
        $levels = Level::where('is_active', true)
            ->with('chapters.lessons')
            ->orderBy('order')
            ->get();

        $levelProgress = $levels->map(function ($level) use ($user) {
            $lessonIds = $level->chapters->flatMap->lessons->pluck('id');
            $totalLessons = $lessonIds->count();
            $completedLessons = UserLessonProgress::where('user_id', $user->id)
                ->whereIn('lesson_id', $lessonIds)
                ->where('status', 'completed')
                ->count();

            return [
                'level' => $level,
                'total' => $totalLessons,
                'completed' => $completedLessons,
                'percentage' => $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0,
            ];
        });

        // Historique des scores
        $scoreHistory = UserAssessmentResult::where('user_id', $user->id)
            ->orderBy('completed_at', 'desc')
            ->take(20)
            ->with('assessment.lesson')
            ->get();

        // Activité par jour (7 derniers jours)
        $weeklyActivity = $this->getWeeklyActivity($user);

        // Temps d'étude total
        $totalStudyTime = StudySession::where('user_id', $user->id)
            ->sum('duration_minutes');

        return view('progress.index', compact(
            'levelProgress',
            'scoreHistory',
            'weeklyActivity',
            'totalStudyTime'
        ));
    }

    public function history()
    {
        $user = Auth::user();

        $lessonHistory = UserLessonProgress::where('user_id', $user->id)
            ->with('lesson.chapter.level')
            ->orderBy('last_accessed_at', 'desc')
            ->paginate(20);

        return view('progress.history', compact('lessonHistory'));
    }

    public function assessments()
    {
        $user = Auth::user();

        $assessmentHistory = UserAssessmentResult::where('user_id', $user->id)
            ->with('assessment.lesson.chapter')
            ->orderBy('completed_at', 'desc')
            ->paginate(20);

        return view('progress.assessments', compact('assessmentHistory'));
    }

    private function getWeeklyActivity($user)
    {
        $activity = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            
            $lessonsCompleted = UserLessonProgress::where('user_id', $user->id)
                ->whereDate('completed_at', $date)
                ->count();

            $assessmentsTaken = UserAssessmentResult::where('user_id', $user->id)
                ->whereDate('completed_at', $date)
                ->count();

            $activity[] = [
                'date' => $date,
                'day' => Carbon::parse($date)->locale('fr')->isoFormat('ddd'),
                'lessons' => $lessonsCompleted,
                'assessments' => $assessmentsTaken,
            ];
        }

        return $activity;
    }
}