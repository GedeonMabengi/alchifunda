<?php
// database/seeders/InitialAssessmentQuestionSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitialAssessmentQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            // Questions de niveau facile (3ème secondaire)
            [
                'id' => 1,
                'level_id' => 1,
                'question_text' => 'Quel est le symbole chimique de l\'eau ?',
                'question_type' => 'mcq',
                'options' => json_encode([
                    'A' => 'H2O',
                    'B' => 'CO2',
                    'C' => 'NaCl',
                    'D' => 'O2'
                ]),
                'correct_answer' => 'A',
                'difficulty_score' => 1,
                'topic' => 'Molécules et formules',
                'order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'level_id' => 1,
                'question_text' => 'Combien y a-t-il d\'états de la matière principaux ?',
                'question_type' => 'mcq',
                'options' => json_encode([
                    'A' => '2',
                    'B' => '3',
                    'C' => '4',
                    'D' => '5'
                ]),
                'correct_answer' => 'B',
                'difficulty_score' => 1,
                'topic' => 'États de la matière',
                'order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Questions de niveau moyen (4ème secondaire)
            [
                'id' => 3,
                'level_id' => 2,
                'question_text' => 'Le numéro atomique d\'un élément représente :',
                'question_type' => 'mcq',
                'options' => json_encode([
                    'A' => 'Le nombre de neutrons',
                    'B' => 'Le nombre de protons',
                    'C' => 'La masse atomique',
                    'D' => 'Le nombre d\'électrons de valence'
                ]),
                'correct_answer' => 'B',
                'difficulty_score' => 3,
                'topic' => 'Structure atomique',
                'order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'level_id' => 2,
                'question_text' => 'Dans le tableau périodique, les éléments d\'une même colonne ont :',
                'question_type' => 'mcq',
                'options' => json_encode([
                    'A' => 'Le même nombre de masse',
                    'B' => 'Le même nombre d\'électrons de valence',
                    'C' => 'Le même nombre de neutrons',
                    'D' => 'La même masse atomique'
                ]),
                'correct_answer' => 'B',
                'difficulty_score' => 4,
                'topic' => 'Tableau périodique',
                'order' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('initial_assessment_questions')->insert($questions);
    }
}