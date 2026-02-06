<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAssessmentResult extends Model
{
    protected $fillable = [
        'user_id',
        'assessment_id',
        'score',
        'percentage',
        'passed',
        'attempt_number',
        'time_taken_minutes',
        'answers',
        'ai_feedback',
        'weak_points',
        'strong_points',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'passed' => 'boolean',
        'answers' => 'array',
        'weak_points' => 'array',
        'strong_points' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }
}
