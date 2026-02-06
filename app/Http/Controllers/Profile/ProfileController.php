<?php
// app/Http/Controllers/Profile/ProfileController.php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\UserAssessmentResult;
use App\Models\UserLessonProgress;
use App\Models\UserAchievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $preferences = $user->preferences;

        // Statistiques détaillées
        $stats = [
            'total_lessons' => UserLessonProgress::where('user_id', $user->id)->count(),
            'completed_lessons' => UserLessonProgress::where('user_id', $user->id)
                ->where('status', 'completed')->count(),
            'total_assessments' => UserAssessmentResult::where('user_id', $user->id)->count(),
            'passed_assessments' => UserAssessmentResult::where('user_id', $user->id)
                ->where('passed', true)->count(),
            'average_score' => round(UserAssessmentResult::where('user_id', $user->id)
                ->avg('percentage') ?? 0),
            'total_time_minutes' => UserLessonProgress::where('user_id', $user->id)
                ->sum('time_spent_minutes'),
            'achievements_count' => UserAchievement::where('user_id', $user->id)->count(),
        ];

        // Évolution des scores (derniers 10 assessments)
        $scoreHistory = UserAssessmentResult::where('user_id', $user->id)
            ->orderBy('completed_at', 'desc')
            ->take(10)
            ->get(['percentage', 'completed_at'])
            ->reverse();

        return view('profile.show', compact('user', 'profile', 'preferences', 'stats', 'scoreHistory'));
    }

    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $levels = Level::where('is_active', true)->orderBy('order')->get();

        return view('profile.edit', compact('user', 'profile', 'levels'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'age' => 'nullable|integer|min:10|max:100',
            'school_option' => 'nullable|string|max:255',
            'school_name' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'study_time_per_day' => 'nullable|integer|min:10|max:480',
            'study_days_per_week' => 'nullable|integer|min:1|max:7',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        $user->profile->update([
            'age' => $validated['age'],
            'school_option' => $validated['school_option'],
            'school_name' => $validated['school_name'],
            'city' => $validated['city'],
            'province' => $validated['province'],
            'study_time_per_day' => $validated['study_time_per_day'],
            'study_days_per_week' => $validated['study_days_per_week'],
        ]);

        return redirect()->route('profile.show')
            ->with('success', 'Profil mis à jour avec succès.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Mot de passe mis à jour avec succès.');
    }
}