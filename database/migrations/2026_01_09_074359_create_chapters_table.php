<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chapters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('level_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('objectives')->nullable(); // Objectifs du chapitre (JSON ou texte)
            $table->integer('order'); // Ordre dans le niveau
            $table->integer('estimated_duration_minutes')->nullable(); // Durée estimée totale
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index(['level_id', 'order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chapters');
    }
};