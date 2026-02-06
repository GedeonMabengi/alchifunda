<?php
// database/seeders/LevelSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            [
                'id' => 1,
                'name' => '3ème Secondaire',
                'code' => '3SEC',
                'description' => 'Troisième année du cycle secondaire - Introduction à la chimie. Ce niveau couvre les fondamentaux de la chimie incluant la structure de la matière, les éléments chimiques et les premières réactions.',
                'order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => '4ème Secondaire',
                'code' => '4SEC',
                'description' => 'Quatrième année du cycle secondaire - Chimie fondamentale. Approfondissement des notions de base avec introduction aux liaisons chimiques et aux calculs stœchiométriques.',
                'order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('levels')->insert($levels);
    }
}