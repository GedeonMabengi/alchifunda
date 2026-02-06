<?php
// routes/web.php

use Illuminate\Support\Facades\Route;

// Controllers Auth
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Controllers principaux
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Assessment\InitialAssessmentController;
use App\Http\Controllers\Assessment\AssessmentController;
use App\Http\Controllers\Learning\LevelController;
use App\Http\Controllers\Learning\ChapterController;
use App\Http\Controllers\Learning\LessonController;
use App\Http\Controllers\Progress\ProgressController;
use App\Http\Controllers\Progress\AchievementController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Profile\PreferenceController;
use App\Http\Controllers\AI\AIConversationController;
use App\Http\Controllers\Notification\NotificationController;

/*
|--------------------------------------------------------------------------
| Routes Publiques
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::get('/', function () {
//     return Inertia::render('welcome');
// })->name('home');

/*
|--------------------------------------------------------------------------
| Routes d'Authentification
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Route::middleware('guest')->group(function () {
//     // Inscription
//     Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
//     Route::post('/register', [RegisterController::class, 'register']);

//     // Connexion
//     Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
//     Route::post('/login', [LoginController::class, 'login']);

//     // Mot de passe oublié
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
// });

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Routes Protégées (Authentification requise)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Évaluation Initiale
    |--------------------------------------------------------------------------
    */
    Route::prefix('initial-assessment')->name('initial-assessment.')->group(function () {
        Route::get('/', [InitialAssessmentController::class, 'start'])->name('start');
        Route::get('/profile', [InitialAssessmentController::class, 'profileStep'])->name('profile');
        Route::post('/profile', [InitialAssessmentController::class, 'saveProfile'])->name('profile.save');
        Route::get('/knowledge', [InitialAssessmentController::class, 'knowledgeStep'])->name('knowledge');
        Route::post('/knowledge', [InitialAssessmentController::class, 'saveKnowledge'])->name('knowledge.save');
        Route::get('/preferences', [InitialAssessmentController::class, 'preferencesStep'])->name('preferences');
        Route::post('/preferences', [InitialAssessmentController::class, 'savePreferences'])->name('preferences.save');
        Route::get('/complete', [InitialAssessmentController::class, 'complete'])->name('complete');
    });

    /*
    |--------------------------------------------------------------------------
    | Routes nécessitant l'évaluation initiale complétée
    |--------------------------------------------------------------------------
    */
    Route::middleware('assessment.completed')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | Tableau de Bord
        |--------------------------------------------------------------------------
        */
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Apprentissage - Niveaux
        |--------------------------------------------------------------------------
        */
        Route::prefix('levels')->name('level.')->group(function () {
            Route::get('/', [LevelController::class, 'index'])->name('index');
            Route::get('/{code}', [LevelController::class, 'show'])->name('show');
        });

        /*
        |--------------------------------------------------------------------------
        | Apprentissage - Chapitres
        |--------------------------------------------------------------------------
        */
        Route::prefix('chapters')->name('chapter.')->group(function () {
            Route::get('/', [ChapterController::class, 'index'])->name('index');
            Route::get('/level/{levelCode}', [ChapterController::class, 'index'])->name('by-level');
            Route::get('/{slug}', [ChapterController::class, 'show'])->name('show');
        });

        /*
        |--------------------------------------------------------------------------
        | Apprentissage - Leçons
        |--------------------------------------------------------------------------
        */
        Route::prefix('lessons')->name('lesson.')->group(function () {
            Route::get('/', [LessonController::class, 'index'])->name('index');
            Route::get('/{chapterSlug}/{lessonSlug}', [LessonController::class, 'show'])->name('show');
            Route::post('/{lessonId}/complete', [LessonController::class, 'complete'])->name('complete');
            Route::post('/{lessonId}/ask-ai', [LessonController::class, 'askAI'])->name('ask-ai');
        });

        /*
        |--------------------------------------------------------------------------
        | Évaluations (Quiz et Contrôles)
        |--------------------------------------------------------------------------
        */
        Route::prefix('assessments')->name('assessment.')->group(function () {
            Route::get('/{assessmentId}/start', [AssessmentController::class, 'start'])->name('start');
            Route::post('/{assessmentId}/submit', [AssessmentController::class, 'submit'])->name('submit');
            Route::get('/result/{resultId}', [AssessmentController::class, 'result'])->name('result');
            Route::get('/{assessmentId}/retry', [AssessmentController::class, 'retry'])->name('retry');
        });

        /*
        |--------------------------------------------------------------------------
        | Progression
        |--------------------------------------------------------------------------
        */
        Route::prefix('progress')->name('progress.')->group(function () {
            Route::get('/', [ProgressController::class, 'index'])->name('index');
            Route::get('/history', [ProgressController::class, 'history'])->name('history');
            Route::get('/assessments', [ProgressController::class, 'assessments'])->name('assessments');
        });

        /*
        |--------------------------------------------------------------------------
        | Récompenses
        |--------------------------------------------------------------------------
        */
        Route::get('/achievements', [AchievementController::class, 'index'])->name('achievement.index');

        /*
        |--------------------------------------------------------------------------
        | Profil
        |--------------------------------------------------------------------------
        */
        Route::prefix('profile')->name('profile.')->group(function () {
            Route::get('/', [ProfileController::class, 'show'])->name('show');
            Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
            Route::put('/', [ProfileController::class, 'update'])->name('update');
            Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        });

        /*
        |--------------------------------------------------------------------------
        | Préférences
        |--------------------------------------------------------------------------
        */
        Route::prefix('preferences')->name('preferences.')->group(function () {
            Route::get('/', [PreferenceController::class, 'edit'])->name('edit');
            Route::put('/', [PreferenceController::class, 'update'])->name('update');
        });

        /*
        |--------------------------------------------------------------------------
        | Conversations IA
        |--------------------------------------------------------------------------
        */
        Route::prefix('ai')->name('ai.')->group(function () {
            Route::post('/ask', [AIConversationController::class, 'ask'])->name('ask');
            Route::get('/history', [AIConversationController::class, 'history'])->name('history');
        });

        /*
        |--------------------------------------------------------------------------
        | Notifications
        |--------------------------------------------------------------------------
        */
        Route::prefix('notifications')->name('notification.')->group(function () {
            Route::get('/', [NotificationController::class, 'index'])->name('index');
            Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('read');
            Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('read-all');
            Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
            Route::get('/unread-count', [NotificationController::class, 'getUnreadCount'])->name('unread-count');
        });
    });
});

/*
|--------------------------------------------------------------------------
| Routes API (pour les requêtes AJAX)
|--------------------------------------------------------------------------
*/

Route::prefix('api')->middleware('auth')->group(function () {
    Route::post('/ai/ask', [AIConversationController::class, 'ask']);
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount']);
});
