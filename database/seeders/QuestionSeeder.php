<?php
// database/seeders/QuestionSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            // Questions pour Mini-Quiz "La Matière" (assessment_id = 1)
            [
                'id' => 1,
                'assessment_id' => 1,
                'question_text' => 'Qu\'est-ce que la matière ?',
                'question_type' => 'mcq',
                'options' => json_encode([
                    'A' => 'Tout ce qui a une couleur',
                    'B' => 'Tout ce qui a une masse et occupe un volume',
                    'C' => 'Tout ce qui est visible',
                    'D' => 'Tout ce qui est solide'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'La matière est définie comme tout ce qui possède une masse (quantité de matière) et occupe un espace (volume). Cela inclut les solides, les liquides et les gaz, qu\'ils soient visibles ou non.',
                'points' => 10,
                'order' => 1,
                'difficulty' => 'easy',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'assessment_id' => 1,
                'question_text' => 'La densité est le rapport entre :',
                'question_type' => 'mcq',
                'options' => json_encode([
                    'A' => 'La masse et le temps',
                    'B' => 'Le volume et la température',
                    'C' => 'La masse et le volume',
                    'D' => 'La longueur et la largeur'
                ]),
                'correct_answer' => 'C',
                'explanation' => 'La densité (ρ) est définie par la formule ρ = m/V, où m est la masse et V est le volume. Elle exprime combien de masse est contenue dans une unité de volume.',
                'points' => 10,
                'order' => 2,
                'difficulty' => 'easy',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Questions pour Contrôle "La Matière" (assessment_id = 2)
            [
                'id' => 3,
                'assessment_id' => 2,
                'question_text' => 'Les propriétés physiques de la matière sont celles qui :',
                'question_type' => 'mcq',
                'options' => json_encode([
                    'A' => 'Modifient la nature de la substance',
                    'B' => 'Sont observables sans modifier la nature de la substance',
                    'C' => 'Ne peuvent jamais être mesurées',
                    'D' => 'Concernent uniquement les gaz'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'Les propriétés physiques (couleur, densité, point de fusion, etc.) peuvent être observées ou mesurées sans changer la composition chimique de la substance.',
                'points' => 15,
                'order' => 1,
                'difficulty' => 'easy',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'assessment_id' => 2,
                'question_text' => 'Un bloc de fer a une masse de 156 g et un volume de 20 cm³. Calculez sa densité.',
                'question_type' => 'calculation',
                'options' => null,
                'correct_answer' => '7.8',
                'explanation' => 'Densité = masse / volume = 156 g / 20 cm³ = 7,8 g/cm³. La densité du fer est d\'environ 7,8 g/cm³, ce qui correspond à la valeur théorique.',
                'points' => 25,
                'order' => 2,
                'difficulty' => 'medium',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'assessment_id' => 2,
                'question_text' => 'La rouille du fer est un exemple de propriété physique.',
                'question_type' => 'true_false',
                'options' => json_encode(['Vrai' => 'Vrai', 'Faux' => 'Faux']),
                'correct_answer' => 'Faux',
                'explanation' => 'La rouille (oxydation du fer) est une propriété chimique car elle implique une transformation de la substance : le fer réagit avec l\'oxygène pour former de l\'oxyde de fer (rouille), un composé différent.',
                'points' => 15,
                'order' => 3,
                'difficulty' => 'easy',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'assessment_id' => 2,
                'question_text' => 'Citez deux propriétés physiques de l\'eau.',
                'question_type' => 'short_answer',
                'options' => null,
                'correct_answer' => 'point d\'ébullition 100°C, point de fusion 0°C, liquide incolore, densité 1 g/cm³',
                'explanation' => 'Les propriétés physiques de l\'eau incluent : son point d\'ébullition (100°C), son point de fusion (0°C), sa densité (1 g/cm³), sa couleur (incolore), son absence d\'odeur, etc.',
                'points' => 20,
                'order' => 4,
                'difficulty' => 'medium',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Questions pour Mini-Quiz "États de la Matière" (assessment_id = 3)
            [
                'id' => 7,
                'assessment_id' => 3,
                'question_text' => 'Dans quel état les particules sont-elles les plus éloignées les unes des autres ?',
                'question_type' => 'mcq',
                'options' => json_encode([
                    'A' => 'Solide',
                    'B' => 'Liquide',
                    'C' => 'Gazeux',
                    'D' => 'Elles sont toujours à la même distance'
                ]),
                'correct_answer' => 'C',
                'explanation' => 'Dans un gaz, les particules sont très éloignées les unes des autres et se déplacent librement dans toutes les directions. C\'est pourquoi les gaz sont compressibles et occupent tout l\'espace disponible.',
                'points' => 10,
                'order' => 1,
                'difficulty' => 'easy',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'assessment_id' => 3,
                'question_text' => 'Un liquide a un volume fixe mais pas de forme propre.',
                'question_type' => 'true_false',
                'options' => json_encode(['Vrai' => 'Vrai', 'Faux' => 'Faux']),
                'correct_answer' => 'Vrai',
                'explanation' => 'C\'est exact ! Un liquide conserve son volume (il est pratiquement incompressible) mais prend la forme de son récipient car ses particules peuvent glisser les unes sur les autres.',
                'points' => 10,
                'order' => 2,
                'difficulty' => 'easy',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Questions pour Contrôle "États de la Matière" (assessment_id = 4)
            [
                'id' => 9,
                'assessment_id' => 4,
                'question_text' => 'Quelle propriété distingue principalement un solide d\'un liquide ?',
                'question_type' => 'mcq',
                'options' => json_encode([
                    'A' => 'Le solide a une masse, le liquide non',
                    'B' => 'Le solide a une forme propre, le liquide non',
                    'C' => 'Le solide est toujours froid',
                    'D' => 'Le liquide est toujours transparent'
                ]),
                'correct_answer' => 'B',
                'explanation' => 'La différence fondamentale est que le solide a une forme propre (ses particules sont fixes) tandis que le liquide prend la forme de son contenant (ses particules peuvent se déplacer).',
                'points' => 15,
                'order' => 1,
                'difficulty' => 'easy',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'assessment_id' => 4,
                'question_text' => 'Expliquez pourquoi les gaz sont compressibles mais pas les liquides.',
                'question_type' => 'short_answer',
                'options' => null,
                'correct_answer' => 'particules éloignées gaz, particules proches liquide, espace vide gaz',
                'explanation' => 'Dans un gaz, les particules sont très éloignées avec beaucoup d\'espace vide entre elles, ce qui permet de les rapprocher par compression. Dans un liquide, les particules sont déjà très proches, laissant peu d\'espace pour la compression.',
                'points' => 25,
                'order' => 2,
                'difficulty' => 'medium',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('questions')->insert($questions);
    }
}
