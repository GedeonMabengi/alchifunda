<?php

namespace App\Services;

class AIServicex
{
    /**
     * Simule une requête à une API IA ou retourne une réponse.
     */
    public function ask(string $question, array $context = []): string
    {
        // Ici tu peux appeler ton vrai service IA, par exemple OpenAI ou Claude
        // Pour l'instant, on retourne juste une réponse factice
        return "Réponse simulée pour : " . $question;
    }

    // public function adaptContent(Lesson $lesson, $preferences)
    public function adaptContent($lesson, $preferences)
    {
        // Ici tu peux faire ce que tu veux : simplifier le texte,
        // changer la langue, ajouter des exemples, etc.
        // Pour l'instant, on retourne simplement le contenu original.

        return $lesson->content ?? '';
    }
}
