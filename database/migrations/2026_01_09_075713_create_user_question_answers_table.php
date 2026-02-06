<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_question_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_assessment_result_id')->constrained('user_assessment_results')->onDelete('cascade');
            $table->foreignId('question_id')->constrained()->onDelete('cascade');
            $table->text('user_answer')->nullable();
            $table->boolean('is_correct');
            $table->integer('points_earned')->default(0);
            $table->text('ai_explanation')->nullable(); // Explication personnalisée par l'IA
            $table->timestamps();
            
            // Remplacer cette ligne :
            // $table->index(['user_assessment_result_id', 'question_id']);
            
            // Par celle-ci avec un nom court :
            $table->index(['user_assessment_result_id', 'question_id'], 'ua_result_question_idx');
            
            // Vous pourriez aussi vouloir ajouter un index pour user_id
            // $table->index('user_id', 'ua_user_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_question_answers');
    }
};