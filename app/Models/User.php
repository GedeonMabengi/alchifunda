<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'initial_assessment_completed',
        'is_active',
        'last_login_at',
        'current_level_id',
        'total_points',
        'streak_days',
        'last_active_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token', // Supprimez les références à two_factor
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'initial_assessment_completed' => 'boolean',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
            'last_active_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Relations avec les autres modèles
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function preferences()
    {
        return $this->hasOne(UserPreferences::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'current_level_id');
    }

    public function lessonProgresses()
    {
        return $this->hasMany(UserLessonProgress::class);
    }

    public function lessonProgress()
    {
        return $this->hasMany(UserLessonProgress::class);
    }

    public function assessmentResults()
    {
        return $this->hasMany(UserAssessmentResult::class);
    }

    public function questionAnswers()
    {
        return $this->hasMany(UserQuestionAnswer::class);
    }

    /**
     * Méthodes pratiques
     */
    public function completeInitialAssessment()
    {
        $this->update([
            'initial_assessment_completed' => true,
            'initial_assessment_completed_at' => now(),
        ]);
    }

    public function updateStreak()
    {
        if (!$this->last_active_at || $this->last_active_at->lt(now()->subDay())) {
            $this->streak_days = 1;
        } elseif ($this->last_active_at->lt(now()->subDays(2))) {
            $this->streak_days = 0;
        } else {
            $this->increment('streak_days');
        }
        
        $this->last_active_at = now();
        $this->save();
    }

    public function addPoints(int $points)
    {
        $this->total_points += $points;
        $this->save();
        
        // Vérifier si l'utilisateur peut monter de niveau
        $this->checkLevelUp();
    }

    public function checkLevelUp()
    {
        $nextLevel = Level::where('required_points', '>', $this->total_points)
            ->orderBy('required_points')
            ->first();
            
        if ($nextLevel && $this->current_level_id !== $nextLevel->id) {
            $this->current_level_id = $nextLevel->id;
            $this->save();
            
            // Événement ou log pour la montée de niveau
            // event(new UserLeveledUp($this, $nextLevel));
        }
    }

    /**
     * Relation : Un utilisateur a plusieurs conversations IA
     */
    public function aiConversations()
    {
        return $this->hasMany(AIConversation::class);
    }

    public function achievements()
{
    return $this->belongsToMany(Achievement::class, 'user_achievements')
        ->withPivot('earned_at')  // ✅ Bon nom selon ta migration
        ->withTimestamps();
}
}