<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description');
            $table->string('icon')->nullable(); // Nom de l'icône ou chemin
            $table->enum('type', ['lesson', 'chapter', 'streak', 'score', 'special'])->default('lesson');
            $table->json('criteria'); // Critères pour obtenir le badge (JSON)
            $table->integer('points_reward')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('achievements');
    }
};