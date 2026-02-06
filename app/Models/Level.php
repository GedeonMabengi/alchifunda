<?php
// app/Models/Level.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = [
        'name',
        'code',
        'is_active',
        'order',
        // ajoute d'autres champs selon ta migration
    ];

    // Relation : un niveau a plusieurs chapitres
    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }

    public function assessments()
    {
        return $this->hasMany(Assessment::class);
    }

}
