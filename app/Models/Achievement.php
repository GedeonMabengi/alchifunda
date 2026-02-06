<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Achievement extends Model
{
    protected $fillable = [
        'name',
        'code',
        'description',
        'icon',
        'type',
        'criteria',
        'points_reward',
        'is_active',
    ];

    protected $casts = [
        'criteria' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Un badge peut être obtenu par plusieurs utilisateurs
     */
    public function userAchievements(): HasMany
    {
        return $this->hasMany(UserAchievement::class);
    }
}
