<?php
// database/seeders/AssessmentSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssessmentSeeder extends Seeder
{
    public function run(): void
    {
        $assessments = [
            // Mini-quiz pour "Qu'est-ce que la Matière ?"
            [
                'id' => 1,
                'lesson_id' => 1,
                'title' => 'Mini-Quiz : La Matière',
                'type' => 'mini_quiz',
                'instructions' => 'Répondez à ces questions rapides pour vérifier votre compréhension.',
                'total_points' => 30,
                'passing_score' => 60,
                'time_limit_minutes' => null,
                'max_attempts' => 10,
                'shuffle_questions' => false,
                'show_correct_answers' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Contrôle de fin de leçon pour "Qu'est-ce que la Matière ?"
            [
                'id' => 2,
                'lesson_id' => 1,
                'title' => 'Contrôle : Qu\'est-ce que la Matière ?',
                'type' => 'end_lesson_control',
                'instructions' => 'Ce contrôle évalue votre compréhension de la leçon sur la matière. Vous avez 3 tentatives maximum. Un score de 70% est requis pour valider la leçon.',
                'total_points' => 100,
                'passing_score' => 70,
                'time_limit_minutes' => 20,
                'max_attempts' => 3,
                'shuffle_questions' => true,
                'show_correct_answers' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Mini-quiz pour "Les Trois États de la Matière"
            [
                'id' => 3,
                'lesson_id' => 2,
                'title' => 'Mini-Quiz : Les États de la Matière',
                'type' => 'mini_quiz',
                'instructions' => 'Testez rapidement vos connaissances sur les trois états de la matière.',
                'total_points' => 30,
                'passing_score' => 60,
                'time_limit_minutes' => null,
                'max_attempts' => 10,
                'shuffle_questions' => false,
                'show_correct_answers' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Contrôle de fin de leçon pour "Les Trois États de la Matière"
            [
                'id' => 4,
                'lesson_id' => 2,
                'title' => 'Contrôle : Les Trois États de la Matière',
                'type' => 'end_lesson_control',
                'instructions' => 'Évaluation complète sur les trois états de la matière. Score minimum requis : 70%.',
                'total_points' => 100,
                'passing_score' => 70,
                'time_limit_minutes' => 25,
                'max_attempts' => 3,
                'shuffle_questions' => true,
                'show_correct_answers' => true,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('assessments')->insert($assessments);
    }
}