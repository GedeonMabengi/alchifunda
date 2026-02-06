<?php
// database/seeders/ChapterSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChapterSeeder extends Seeder
{
    public function run(): void
    {
        $chapters = [
            // Chapitres pour 3ème Secondaire
            [
                'id' => 1,
                'level_id' => 1,
                'title' => 'La Matière et ses États',
                'slug' => 'la-matiere-et-ses-etats',
                'description' => 'Ce chapitre introduit les concepts fondamentaux de la matière, ses propriétés et ses trois états physiques : solide, liquide et gazeux.',
                'objectives' => json_encode([
                    'Définir la matière et ses propriétés',
                    'Distinguer les trois états de la matière',
                    'Expliquer les changements d\'état',
                    'Identifier des exemples dans la vie quotidienne au Congo'
                ]),
                'order' => 1,
                'estimated_duration_minutes' => 120,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'level_id' => 1,
                'title' => 'L\'Atome et sa Structure',
                'slug' => 'l-atome-et-sa-structure',
                'description' => 'Découverte de l\'atome comme constituant fondamental de la matière, sa structure interne avec le noyau et les électrons.',
                'objectives' => json_encode([
                    'Décrire la structure de l\'atome',
                    'Identifier les particules subatomiques',
                    'Comprendre la notion de numéro atomique',
                    'Utiliser la notation atomique'
                ]),
                'order' => 2,
                'estimated_duration_minutes' => 150,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Chapitres pour 4ème Secondaire
            [
                'id' => 3,
                'level_id' => 2,
                'title' => 'Le Tableau Périodique des Éléments',
                'slug' => 'le-tableau-periodique-des-elements',
                'description' => 'Étude approfondie du tableau périodique, son organisation et les propriétés périodiques des éléments.',
                'objectives' => json_encode([
                    'Comprendre l\'organisation du tableau périodique',
                    'Identifier les familles chimiques',
                    'Prédire les propriétés des éléments',
                    'Utiliser le tableau pour résoudre des problèmes'
                ]),
                'order' => 1,
                'estimated_duration_minutes' => 180,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'level_id' => 2,
                'title' => 'Les Liaisons Chimiques',
                'slug' => 'les-liaisons-chimiques',
                'description' => 'Comprendre comment les atomes se lient pour former des molécules et des composés chimiques.',
                'objectives' => json_encode([
                    'Distinguer les types de liaisons chimiques',
                    'Expliquer la liaison covalente',
                    'Expliquer la liaison ionique',
                    'Représenter les molécules avec la notation de Lewis'
                ]),
                'order' => 2,
                'estimated_duration_minutes' => 200,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('chapters')->insert($chapters);
    }
}