<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_assessment_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('assessment_id')->constrained()->onDelete('cascade');
            $table->integer('score'); // Score obtenu en points
            $table->integer('percentage'); // Score en pourcentage
            $table->boolean('passed'); // Réussi ou non
            $table->integer('attempt_number')->default(1); // Numéro de tentative
            $table->integer('time_taken_minutes')->nullable(); // Temps pris
            $table->json('answers')->nullable(); // Réponses données par l'utilisateur
            $table->longText('ai_feedback')->nullable(); // Feedback généré par l'IA
            $table->json('weak_points')->nullable(); // Points faibles identifiés
            $table->json('strong_points')->nullable(); // Points forts identifiés
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'assessment_id']);
            $table->index(['user_id', 'passed']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_assessment_results');
    }
};