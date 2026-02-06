<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapter_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('introduction')->nullable(); // Introduction de la leçon
            $table->longText('content'); // Contenu principal de la leçon
            $table->longText('math_demonstrations')->nullable(); // Démonstrations mathématiques (JSON ou Markdown)
            $table->longText('practical_examples')->nullable(); // Exemples pratiques (JSON)
            $table->text('summary')->nullable(); // Résumé de la leçon
            $table->json('keywords')->nullable(); // Mots-clés pour la recherche
            $table->integer('order'); // Ordre dans le chapitre
            $table->integer('estimated_duration_minutes')->default(30);
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['chapter_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};