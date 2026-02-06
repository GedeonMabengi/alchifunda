<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained()->onDelete('cascade');
            $table->text('question_text');
            $table->enum('question_type', ['mcq', 'true_false', 'short_answer', 'calculation', 'fill_blank'])->default('mcq');
            $table->json('options')->nullable(); // Pour les QCM : ["A" => "Option 1", "B" => "Option 2", ...]
            $table->text('correct_answer'); // Réponse correcte
            $table->text('explanation')->nullable(); // Explication de la réponse
            $table->integer('points')->default(10);
            $table->integer('order');
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['assessment_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};