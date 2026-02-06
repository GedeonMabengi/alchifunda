<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    protected $fillable = [
        'chapter_id',
        'title',
        'content',
        'order',
        'is_active',
    ];

    /**
     * Une leçon appartient à un chapitre
     */
    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }
}
