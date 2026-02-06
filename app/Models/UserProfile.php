<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'age',
        'declared_level_id',
        'assessed_level_id',
        'study_time_per_day',
        'study_days_per_week',
        'school_option',
        'school_name',
        'city',
        'province',
        'global_score',
        'total_lessons_completed',
        'total_assessments_passed',
        'current_streak_days',
        'longest_streak_days',
        'last_activity_date',
    ];

    protected $casts = [
        'last_activity_date' => 'date',
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function declaredLevel(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'declared_level_id');
    }

    public function assessedLevel(): BelongsTo
    {
        return $this->belongsTo(Level::class, 'assessed_level_id');
    }
}
