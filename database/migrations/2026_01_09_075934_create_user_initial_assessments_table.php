<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_initial_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('responses'); // Toutes les réponses données
            $table->integer('total_score');
            $table->foreignId('recommended_level_id')->nullable()->constrained('levels')->onDelete('set null');
            $table->json('topic_scores')->nullable(); // Scores par sujet
            $table->longText('ai_analysis')->nullable(); // Analyse détaillée par l'IA
            $table->json('recommended_starting_chapters')->nullable(); // Chapitres recommandés pour commencer
            $table->timestamp('completed_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_initial_assessments');
    }
};