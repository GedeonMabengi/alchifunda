<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('initial_assessment_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('level_id')->nullable()->constrained()->onDelete('set null'); // Niveau ciblé par la question
            $table->text('question_text');
            $table->enum('question_type', ['mcq', 'true_false', 'short_answer'])->default('mcq');
            $table->json('options')->nullable();
            $table->text('correct_answer');
            $table->integer('difficulty_score')->default(1); // 1-10, pour calibrer le niveau
            $table->string('topic')->nullable(); // Sujet couvert (atomes, réactions, etc.)
            $table->integer('order');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('initial_assessment_questions');
    }
};