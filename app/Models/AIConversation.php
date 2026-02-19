<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'attachment_filename',
        'attachment_mime_type',
        'attachment_path',
        'has_attachment',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
        'has_attachment' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function attachmentUrl(): ?string
    {
        return $this->attachment_path ? Storage::url($this->attachment_path) : null;
    }

    public function isImage(): bool
    {
        return $this->has_attachment && str_starts_with($this->attachment_mime_type, 'image/');
    }

    public function isPdf(): bool
    {
        return $this->has_attachment && $this->attachment_mime_type === 'application/pdf';
    }
}