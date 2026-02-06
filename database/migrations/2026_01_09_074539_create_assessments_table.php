<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->enum('type', ['mini_quiz', 'end_lesson_control', 'chapter_exam'])->default('end_lesson_control');
            $table->text('instructions')->nullable();
            $table->integer('total_points')->default(100);
            $table->integer('passing_score')->default(70); // Score minimum pour réussir (en %)
            $table->integer('time_limit_minutes')->nullable(); // Limite de temps (null = illimité)
            $table->integer('max_attempts')->default(3); // Nombre maximum de tentatives
            $table->boolean('shuffle_questions')->default(true);
            $table->boolean('show_correct_answers')->default(true); // Montrer les bonnes réponses après
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};