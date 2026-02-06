<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Note: minuscule pour auth/login
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Mettre à jour les informations de connexion
            $user->update([
                'last_login_at' => now(),
                'last_active_at' => now(),
                'is_active' => true,
            ]);
            
            // Mettre à jour la série (streak)
            $user->updateStreak();

            if (!$user->initial_assessment_completed) {
                return redirect()->route('initial-assessment.start');
            }

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Les identifiants fournis ne correspondent pas.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // Marquer l'utilisateur comme inactif
        if (Auth::check()) {
            Auth::user()->update(['is_active' => false]);
        }
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}