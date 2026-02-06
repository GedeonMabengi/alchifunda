<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 3ème secondaire, 4ème secondaire, etc.
            $table->string('code')->unique(); // 3SEC, 4SEC, 5HUM, 6HUM
            $table->text('description')->nullable();
            $table->integer('order'); // Pour ordonner les niveaux
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};