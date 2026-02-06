<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('age')->nullable();
            $table->foreignId('declared_level_id')->nullable()->constrained('levels')->onDelete('set null'); // Niveau déclaré par l'utilisateur
            $table->foreignId('assessed_level_id')->nullable()->constrained('levels')->onDelete('set null'); // Niveau évalué par l'IA
            $table->integer('study_time_per_day')->nullable(); // En minutes
            $table->integer('study_days_per_week')->nullable();
            $table->string('school_option')->nullable(); // Scientifique, Littéraire, Commercial, etc.
            $table->string('school_name')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->integer('global_score')->default(0); // Score global de l'apprenant
            $table->integer('total_lessons_completed')->default(0);
            $table->integer('total_assessments_passed')->default(0);
            $table->integer('current_streak_days')->default(0); // Jours consécutifs d'apprentissage
            $table->integer('longest_streak_days')->default(0);
            $table->date('last_activity_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};