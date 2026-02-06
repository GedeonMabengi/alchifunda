<?php
// app/Http/Controllers/Profile/PreferenceController.php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreferenceController extends Controller
{
    public function edit()
    {
        $preferences = Auth::user()->preferences;
        return view('profile.preferences', compact('preferences'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'tone' => 'required|in:formal,casual,friendly',
            'detail_level' => 'required|in:concise,moderate,detailed',
            'example_style' => 'required|in:everyday,scientific,mixed',
            'show_math_steps' => 'boolean',
            'enable_notifications' => 'boolean',
            'enable_reminders' => 'boolean',
            'preferred_study_time' => 'nullable|date_format:H:i',
        ]);

        Auth::user()->preferences->update($validated);

        return back()->with('success', 'Préférences mises à jour avec succès.');
    }
}