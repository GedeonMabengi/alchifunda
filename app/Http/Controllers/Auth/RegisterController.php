<?php
// app/Http/Controllers/Auth/RegisterController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
// use Inertia\Inertia;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        // return Inertia::render('auth.register');
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'initial_assessment_completed' => false,
        ]);

        // Créer le profil vide
        UserProfile::create(['user_id' => $user->id]);
        
        // Créer les préférences par défaut
        UserPreference::create(['user_id' => $user->id]);

        Auth::login($user);

        return redirect()->route('initial-assessment.start');
    }
}