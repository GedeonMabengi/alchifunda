<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_conversations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('lesson_id')->nullable()->constrained()->onDelete('set null');

            // ✅ Ajout de 'file_analysis'
            $table->enum('context', [
                'lesson_help',
                'initial_assessment',
                'general_question',
                'feedback',
                'file_analysis',
            ])->default('lesson_help');

            $table->longText('user_message');
            $table->longText('ai_response');

            $table->string('attachment_filename')->nullable();
            $table->string('attachment_mime_type')->nullable();
            $table->string('attachment_path')->nullable();
            $table->boolean('has_attachment')->default(false);

            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'context']);
            $table->index(['user_id', 'lesson_id']);
            $table->index('has_attachment');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_conversations');
    }
};
