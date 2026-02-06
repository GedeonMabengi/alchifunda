<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'question_text',
        'question_type',
        'options',
        'correct_answer',
        'explanation',
        'points',
        'order',
        'difficulty',
        'is_active',
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Relation : Une question appartient à une évaluation
     */
    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}