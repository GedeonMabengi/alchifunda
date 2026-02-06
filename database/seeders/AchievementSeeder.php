<?php
// database/seeders/AchievementSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $achievements = [
            [
                'id' => 1,
                'name' => 'Premier Pas',
                'code' => 'first_lesson',
                'description' => 'Félicitations ! Vous avez complété votre première leçon. C\'est le début d\'un beau parcours en chimie !',
                'icon' => 'rocket',
                'type' => 'lesson',
                'criteria' => json_encode(['lessons_completed' => 1]),
                'points_reward' => 10,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Étudiant Régulier',
                'code' => 'streak_7',
                'description' => 'Vous avez étudié pendant 7 jours consécutifs ! La régularité est la clé du succès.',
                'icon' => 'fire',
                'type' => 'streak',
                'criteria' => json_encode(['streak_days' => 7]),
                'points_reward' => 50,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('achievements')->insert($achievements);
    }
}