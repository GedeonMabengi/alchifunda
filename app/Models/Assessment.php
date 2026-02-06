<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'title',
        'type',
        'instructions',
        'total_points',
        'passing_score',
        'time_limit_minutes',
        'max_attempts',
        'shuffle_questions',
        'show_correct_answers',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'shuffle_questions' => 'boolean',
        'show_correct_answers' => 'boolean',
    ];

    /**
     * Relation : Une évaluation appartient à une leçon
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Relation : Une évaluation a plusieurs questions
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}