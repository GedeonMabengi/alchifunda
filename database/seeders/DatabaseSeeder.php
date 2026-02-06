<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            LevelSeeder::class,
            ChapterSeeder::class,
            LessonSeeder::class,
            AssessmentSeeder::class,
            QuestionSeeder::class,
            InitialAssessmentQuestionSeeder::class,
            AchievementSeeder::class,
            UserSeeder::class,
        ]);
    }
}