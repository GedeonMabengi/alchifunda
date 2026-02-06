<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('tone', ['formal', 'casual', 'friendly'])->default('friendly'); // Ton préféré
            $table->enum('detail_level', ['concise', 'moderate', 'detailed'])->default('moderate'); // Niveau de détail
            $table->enum('example_style', ['everyday', 'scientific', 'mixed'])->default('mixed'); // Style d'exemples
            $table->boolean('show_math_steps')->default(true); // Afficher les étapes mathématiques détaillées
            $table->boolean('enable_notifications')->default(true);
            $table->boolean('enable_reminders')->default(true);
            $table->time('preferred_study_time')->nullable(); // Heure préférée pour étudier
            $table->string('language')->default('fr'); // Langue (fr pour français)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_preferences');
    }
};