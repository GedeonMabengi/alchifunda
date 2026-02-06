<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            [
                'name' => '3ème Secondaire',
                'code' => '3SEC',
                'description' => 'Troisième année du cycle secondaire - Introduction à la chimie',
                'order' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '4ème Secondaire',
                'code' => '4SEC',
                'description' => 'Quatrième année du cycle secondaire - Chimie fondamentale',
                'order' => 2,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '5ème Humanités',
                'code' => '5HUM',
                'description' => 'Cinquième année des humanités générales - Chimie approfondie',
                'order' => 3,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => '6ème Humanités',
                'code' => '6HUM',
                'description' => 'Sixième année des humanités générales - Chimie avancée et préparation aux études supérieures',
                'order' => 4,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('levels')->insert($levels);
    }
}