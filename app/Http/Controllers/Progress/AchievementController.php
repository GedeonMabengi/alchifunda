<?php
// app/Http/Controllers/Progress/AchievementController.php

namespace App\Http\Controllers\Progress;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\UserAchievement;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $earnedAchievementIds = UserAchievement::where('user_id', $user->id)
            ->pluck('achievement_id');

        $earnedAchievements = Achievement::whereIn('id', $earnedAchievementIds)
            ->where('is_active', true)
            ->get()
            ->map(function ($achievement) use ($user) {
                $userAchievement = UserAchievement::where('user_id', $user->id)
                    ->where('achievement_id', $achievement->id)
                    ->first();
                $achievement->earned_at = $userAchievement->earned_at;
                return $achievement;
            });

        $lockedAchievements = Achievement::whereNotIn('id', $earnedAchievementIds)
            ->where('is_active', true)
            ->get();

        $totalPoints = $earnedAchievements->sum('points_reward');

        return view('progress.achievements', compact(
            'earnedAchievements',
            'lockedAchievements',
            'totalPoints'
        ));
    }
}