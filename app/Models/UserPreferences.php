<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPreferences extends Model
{
    protected $fillable = [
        'user_id',
        'tone',
        'detail_level',
        'example_style',
        'show_math_steps',
        'enable_notifications',
        'enable_reminders',
        'preferred_study_time',
        'language',
    ];

    protected $casts = [
        'show_math_steps' => 'boolean',
        'enable_notifications' => 'boolean',
        'enable_reminders' => 'boolean',
        'preferred_study_time' => 'datetime:H:i',
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
