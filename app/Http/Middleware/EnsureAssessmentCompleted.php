<?php
// app/Http/Middleware/EnsureAssessmentCompleted.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAssessmentCompleted
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->initial_assessment_completed) {
            return redirect()->route('initial-assessment.start');
        }

        return $next($request);
    }
}