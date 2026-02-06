<?php
// database/seeders/UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Utilisateur 1 : Jean-Pierre (étudiant avancé)
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Jean-Pierre Mukendi',
            'email' => 'jeanpierre@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'initial_assessment_completed' => true,
            'is_active' => true,
            'last_login_at' => now(),
            'created_at' => now()->subDays(30),
            'updated_at' => now(),
        ]);

        DB::table('user_profiles')->insert([
            'id' => 1,
            'user_id' => 1,
            'age' => 17,
            'declared_level_id' => 2, // 4ème Secondaire
            'assessed_level_id' => 2,
            'study_time_per_day' => 45,
            'study_days_per_week' => 5,
            'school_option' => 'Scientifique',
            'school_name' => 'Lycée Bosangani',
            'city' => 'Kinshasa',
            'province' => 'Kinshasa',
            'global_score' => 450,
            'total_lessons_completed' => 3,
            'total_assessments_passed' => 2,
            'current_streak_days' => 5,
            'longest_streak_days' => 12,
            'last_activity_date' => now()->toDateString(),
            'created_at' => now()->subDays(30),
            'updated_at' => now(),
        ]);

        DB::table('user_preferences')->insert([
            'id' => 1,
            'user_id' => 1,
            'tone' => 'friendly',
            'detail_level' => 'detailed',
            'example_style' => 'mixed',
            'show_math_steps' => true,
            'enable_notifications' => true,
            'enable_reminders' => true,
            'preferred_study_time' => '18:00',
            'language' => 'fr',
            'created_at' => now()->subDays(30),
            'updated_at' => now(),
        ]);

        // Utilisateur 2 : Marie (débutante)
        DB::table('users')->insert([
            'id' => 2,
            'name' => 'Marie Kabongo',
            'email' => 'marie@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password123'),
            'initial_assessment_completed' => true,
            'is_active' => true,
            'last_login_at' => now()->subDays(1),
            'created_at' => now()->subDays(15),
            'updated_at' => now(),
        ]);

        DB::table('user_profiles')->insert([
            'id' => 2,
            'user_id' => 2,
            'age' => 15,
            'declared_level_id' => 1, // 3ème Secondaire
            'assessed_level_id' => 1,
            'study_time_per_day' => 30,
            'study_days_per_week' => 4,
            'school_option' => 'Scientifique',
            'school_name' => 'Institut Mwana',
            'city' => 'Lubumbashi',
            'province' => 'Haut-Katanga',
            'global_score' => 120,
            'total_lessons_completed' => 1,
            'total_assessments_passed' => 1,
            'current_streak_days' => 2,
            'longest_streak_days' => 4,
            'last_activity_date' => now()->subDays(1)->toDateString(),
            'created_at' => now()->subDays(15),
            'updated_at' => now(),
        ]);

        DB::table('user_preferences')->insert([
            'id' => 2,
            'user_id' => 2,
            'tone' => 'casual',
            'detail_level' => 'moderate',
            'example_style' => 'everyday',
            'show_math_steps' => true,
            'enable_notifications' => true,
            'enable_reminders' => true,
            'preferred_study_time' => '16:00',
            'language' => 'fr',
            'created_at' => now()->subDays(15),
            'updated_at' => now(),
        ]);

        // Progression de Jean-Pierre
        DB::table('user_lesson_progress')->insert([
            [
                'user_id' => 1,
                'lesson_id' => 1,
                'status' => 'completed',
                'progress_percentage' => 100,
                'time_spent_minutes' => 35,
                'started_at' => now()->subDays(25),
                'completed_at' => now()->subDays(25),
                'last_accessed_at' => now()->subDays(25),
                'access_count' => 3,
                'ai_notes' => 'Bonne compréhension des concepts de base. A posé des questions pertinentes sur la densité.',
                'created_at' => now()->subDays(25),
                'updated_at' => now()->subDays(25),
            ],
            [
                'user_id' => 1,
                'lesson_id' => 2,
                'status' => 'completed',
                'progress_percentage' => 100,
                'time_spent_minutes' => 40,
                'started_at' => now()->subDays(20),
                'completed_at' => now()->subDays(20),
                'last_accessed_at' => now()->subDays(20),
                'access_count' => 2,
                'ai_notes' => 'Excellente compréhension des états de la matière. Maîtrise bien les concepts de particules.',
                'created_at' => now()->subDays(20),
                'updated_at' => now()->subDays(20),
            ],
        ]);

        // Progression de Marie
        DB::table('user_lesson_progress')->insert([
            [
                'user_id' => 2,
                'lesson_id' => 1,
                'status' => 'completed',
                'progress_percentage' => 100,
                'time_spent_minutes' => 50,
                'started_at' => now()->subDays(10),
                'completed_at' => now()->subDays(9),
                'last_accessed_at' => now()->subDays(9),
                'access_count' => 4,
                'ai_notes' => 'Progression régulière. A eu besoin de plus d\'explications sur la densité.',
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(9),
            ],
            [
                'user_id' => 2,
                'lesson_id' => 2,
                'status' => 'in_progress',
                'progress_percentage' => 60,
                'time_spent_minutes' => 25,
                'started_at' => now()->subDays(2),
                'completed_at' => null,
                'last_accessed_at' => now()->subDays(1),
                'access_count' => 2,
                'ai_notes' => null,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(1),
            ],
        ]);

        // Résultats d'évaluations
        DB::table('user_assessment_results')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'assessment_id' => 2, // Contrôle "La Matière"
                'score' => 85,
                'percentage' => 85,
                'passed' => true,
                'attempt_number' => 1,
                'time_taken_minutes' => 15,
                'answers' => json_encode([3 => ['answer' => 'B', 'correct' => true], 4 => ['answer' => '7.8', 'correct' => true]]),
                'ai_feedback' => 'Excellent travail Jean-Pierre ! Vous avez bien maîtrisé les concepts de la matière. Votre calcul de densité était parfait. Continuez ainsi !',
                'weak_points' => json_encode([]),
                'strong_points' => json_encode([3, 4]),
                'started_at' => now()->subDays(25),
                'completed_at' => now()->subDays(25),
                'created_at' => now()->subDays(25),
                'updated_at' => now()->subDays(25),
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'assessment_id' => 2, // Contrôle "La Matière"
                'score' => 70,
                'percentage' => 70,
                'passed' => true,
                'attempt_number' => 2,
                'time_taken_minutes' => 18,
                'answers' => json_encode([3 => ['answer' => 'B', 'correct' => true], 4 => ['answer' => '7.5', 'correct' => false]]),
                'ai_feedback' => 'Bien joué Marie ! Vous avez validé ce contrôle. Attention aux calculs de densité, n\'oubliez pas de vérifier vos divisions. La pratique vous aidera à progresser.',
                'weak_points' => json_encode([4]),
                'strong_points' => json_encode([3]),
                'started_at' => now()->subDays(8),
                'completed_at' => now()->subDays(8),
                'created_at' => now()->subDays(8),
                'updated_at' => now()->subDays(8),
            ],
        ]);

        // Évaluations initiales
        DB::table('user_initial_assessments')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'responses' => json_encode([1 => ['answer' => 'A', 'correct' => true], 2 => ['answer' => 'B', 'correct' => true], 3 => ['answer' => 'B', 'correct' => true], 4 => ['answer' => 'B', 'correct' => true]]),
                'total_score' => 9,
                'recommended_level_id' => 2,
                'topic_scores' => json_encode(['Molécules et formules' => ['correct' => 1, 'total' => 1], 'États de la matière' => ['correct' => 1, 'total' => 1], 'Structure atomique' => ['correct' => 1, 'total' => 1], 'Tableau périodique' => ['correct' => 1, 'total' => 1]]),
                'ai_analysis' => 'Jean-Pierre démontre une excellente base en chimie. Il maîtrise les concepts fondamentaux et montre une compréhension solide de la structure atomique et du tableau périodique. Recommandation : commencer au niveau 4ème secondaire pour maintenir l\'engagement.',
                'recommended_starting_chapters' => json_encode([3, 4]),
                'completed_at' => now()->subDays(30),
                'created_at' => now()->subDays(30),
                'updated_at' => now()->subDays(30),
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'responses' => json_encode([1 => ['answer' => 'A', 'correct' => true], 2 => ['answer' => 'B', 'correct' => true], 3 => ['answer' => 'C', 'correct' => false], 4 => ['answer' => 'A', 'correct' => false]]),
                'total_score' => 2,
                'recommended_level_id' => 1,
                'topic_scores' => json_encode(['Molécules et formules' => ['correct' => 1, 'total' => 1], 'États de la matière' => ['correct' => 1, 'total' => 1], 'Structure atomique' => ['correct' => 0, 'total' => 1], 'Tableau périodique' => ['correct' => 0, 'total' => 1]]),
                'ai_analysis' => 'Marie a de bonnes bases sur les concepts élémentaires comme les molécules et les états de la matière. Elle a besoin de renforcer ses connaissances sur la structure atomique et le tableau périodique. Recommandation : commencer au niveau 3ème secondaire pour consolider les fondamentaux.',
                'recommended_starting_chapters' => json_encode([1, 2]),
                'completed_at' => now()->subDays(15),
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(15),
            ],
        ]);

        // Conversations IA
        DB::table('ai_conversations')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'lesson_id' => 1,
                'context' => 'lesson_help',
                'user_message' => 'Je ne comprends pas bien pourquoi l\'huile flotte sur l\'eau. Peux-tu m\'expliquer ?',
                'ai_response' => 'Excellente question Jean-Pierre ! L\'huile flotte sur l\'eau car elle a une densité plus faible. La densité de l\'huile est environ 0,9 g/cm³, tandis que celle de l\'eau est de 1 g/cm³. Quand tu mets les deux liquides ensemble, le liquide le moins dense (l\'huile) monte au-dessus. C\'est le même principe qui fait flotter un ballon rempli d\'hélium dans l\'air !',
                'metadata' => json_encode(['topic' => 'densité', 'satisfaction' => null]),
                'created_at' => now()->subDays(25),
                'updated_at' => now()->subDays(25),
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'lesson_id' => 1,
                'context' => 'lesson_help',
                'user_message' => 'Comment calculer la densité ? Je suis un peu perdue avec la formule.',
                'ai_response' => 'Pas de souci Marie, je vais t\'expliquer simplement ! La formule de la densité est : densité = masse ÷ volume (ou ρ = m/V). Imagine que tu as un sac de riz de 5 kg qui prend un volume de 4 litres. La densité serait : 5 kg ÷ 4 L = 1,25 kg/L. C\'est comme demander "combien de kilogrammes je peux mettre dans 1 litre ?". Plus c\'est dense, plus c\'est lourd pour le même volume. Tu veux essayer avec un exemple concret ?',
                'metadata' => json_encode(['topic' => 'densité', 'satisfaction' => 'positive']),
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10),
            ],
        ]);

        // Récompenses obtenues
        DB::table('user_achievements')->insert([
            [
                'user_id' => 1,
                'achievement_id' => 1, // Premier Pas
                'earned_at' => now()->subDays(25),
                'created_at' => now()->subDays(25),
                'updated_at' => now()->subDays(25),
            ],
            [
                'user_id' => 2,
                'achievement_id' => 1, // Premier Pas
                'earned_at' => now()->subDays(9),
                'created_at' => now()->subDays(9),
                'updated_at' => now()->subDays(9),
            ],
        ]);

        // Notifications
        DB::table('notifications')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'title' => 'Nouvelle récompense débloquée !',
                'message' => 'Félicitations ! Vous avez obtenu le badge "Premier Pas" pour avoir complété votre première leçon.',
                'type' => 'achievement',
                'data' => json_encode(['achievement_id' => 1]),
                'is_read' => true,
                'read_at' => now()->subDays(24),
                'created_at' => now()->subDays(25),
                'updated_at' => now()->subDays(24),
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'title' => 'Continuez votre progression !',
                'message' => 'Vous n\'avez pas étudié depuis 2 jours. Une petite leçon pour maintenir votre série ?',
                'type' => 'reminder',
                'data' => json_encode(['lesson_suggestion_id' => 3]),
                'is_read' => false,
                'read_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Sessions d'étude
        DB::table('study_sessions')->insert([
            [
                'id' => 1,
                'user_id' => 1,
                'started_at' => now()->subDays(1)->setTime(18, 0),
                'ended_at' => now()->subDays(1)->setTime(18, 45),
                'duration_minutes' => 45,
                'lessons_viewed' => 1,
                'assessments_completed' => 0,
                'questions_asked' => 1,
                'activity_log' => json_encode([
                    ['time' => '18:00', 'action' => 'lesson_start', 'lesson_id' => 3],
                    ['time' => '18:30', 'action' => 'ai_question'],
                    ['time' => '18:45', 'action' => 'session_end'],
                ]),
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
            [
                'id' => 2,
                'user_id' => 2,
                'started_at' => now()->subDays(1)->setTime(16, 0),
                'ended_at' => now()->subDays(1)->setTime(16, 30),
                'duration_minutes' => 30,
                'lessons_viewed' => 1,
                'assessments_completed' => 0,
                'questions_asked' => 0,
                'activity_log' => json_encode([
                    ['time' => '16:00', 'action' => 'lesson_continue', 'lesson_id' => 2],
                    ['time' => '16:30', 'action' => 'session_end'],
                ]),
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1),
            ],
        ]);
    }
}