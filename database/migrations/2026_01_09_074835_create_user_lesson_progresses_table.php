<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_lesson_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('lesson_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['not_started', 'in_progress', 'completed', 'revision_needed'])->default('not_started');
            $table->integer('progress_percentage')->default(0); // 0-100
            $table->integer('time_spent_minutes')->default(0); // Temps passé sur la leçon
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('last_accessed_at')->nullable();
            $table->integer('access_count')->default(0); // Nombre de fois accédée
            $table->text('ai_notes')->nullable(); // Notes générées par l'IA sur la progression
            $table->timestamps();
            
            $table->unique(['user_id', 'lesson_id']);
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_lesson_progress');
    }
};