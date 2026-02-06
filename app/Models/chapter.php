<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chapter extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'level_id',
        'order',
        'is_active',
    ];

    // Relation avec Level
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    // Relation avec Lesson
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    // Relation avec Course (si applicable)
    // public function course()
    // {
    //     return $this->belongsTo(Course::class);
    // }
}
