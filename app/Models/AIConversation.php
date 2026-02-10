<?php
// app/Models/AIConversation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AIConversation extends Model
{
    use HasFactory;

    protected $table = 'ai_conversations';

    protected $fillable = [
        'user_id',
        'lesson_id',
        'context',
        'user_message',
        'ai_response',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    /**
     * Relation : Une conversation appartient à un utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation : Une conversation peut être liée à une leçon
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}