<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AchievementSeederx extends Seeder
{
    public function run(): void
    {
        $achievements = [
            [
                'name' => 'Premier Pas',
                'code' => 'first_lesson',
                'description' => 'Compléter votre première leçon',
                'icon' => 'rocket',
                'type' => 'lesson',
                'criteria' => json_encode(['lessons_completed' => 1]),
                'points_reward' => 10,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Étudiant Régulier',
                'code' => 'streak_7',
                'description' => 'Étudier 7 jours consécutifs',
                'icon' => 'fire',
                'type' => 'streak',
                'criteria' => json_encode(['streak_days' => 7]),
                'points_reward' => 50,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Maître du Chapitre',
                'code' => 'chapter_complete',
                'description' => 'Compléter un chapitre entier avec succès',
                'icon' => 'trophy',
                'type' => 'chapter',
                'criteria' => json_encode(['chapter_completed' => true, 'min_score' => 70]),
                'points_reward' => 100,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Score Parfait',
                'code' => 'perfect_score',
                'description' => 'Obtenir 100% à une évaluation',
                'icon' => 'star',
                'type' => 'score',
                'criteria' => json_encode(['assessment_score' => 100]),
                'points_reward' => 75,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Curieux',
                'code' => 'questions_10',
                'description' => 'Poser 10 questions à l\'IA',
                'icon' => 'lightbulb',
                'type' => 'special',
                'criteria' => json_encode(['ai_questions' => 10]),
                'points_reward' => 25,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('achievements')->insert($achievements);
    }
}