<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AstrologicalUserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Models\AstrologicalUser;
use App\Http\Controllers\GroqAstrologyController;
use App\Jobs\CalculateUserDistances;
use App\Jobs\CalculateCompatibilityMatches;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\ProfileImageController; // Importar el controlador de imágenes
use App\Models\TagMaestro;

// Página principal con splash screen
Route::get('/', function () {
    return auth()->guard()->check() ? redirect()->route('astromatch') : view('home');
})->name('home');

Route::get('/register', function () {
    return view('auth.registro');
})->name('register');

// Ruta de inicio de sesión
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Ruta de cierre de sesión
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Ruta protegida (requiere autenticación)
// ¡MODIFICADO! Ahora apunta al controlador AstrologicalUserController@showAstromatch
Route::get('/astromatch', [AstrologicalUserController::class, 'showAstromatch'])->name('astromatch')->middleware('auth');


Route::post('/register', [AstrologicalUserController::class, 'register'])->name('register.submit');

// Rutas para la integración con Groq
Route::post('/calculate-groq-astrology', [GroqAstrologyController::class, 'calculateAstrology'])->name('groq.calculate-astrology');
Route::get('/groq-response', [GroqAstrologyController::class, 'showResponse'])->name('groq.show-response');

// Ruta para editar perfil (manteniendo groq-response como nombre de vista)
Route::get('/profile/edit', function() {
    $user = Auth::user();
    return view('groq-response', compact('user'));
})->name('profile.edit')->middleware('auth');

// Ruta para mostrar resultados de Groq (modificada para pasar el usuario)
Route::get('/groq-response', function() {
    $user = Auth::user();
    return view('groq-response', compact('user'));
})->name('groq.show-response')->middleware('auth');

Route::put('/profile/update', [AstrologicalUserController::class, 'update'])->name('profile.update')->middleware('auth');

Route::get('/carta_astral', function () {
    return view('carta_astral');
})->name('carta_astral');

Route::get('/compatibilidades', function () {
    return view('compatibilidad_general');
})->name('compatibilidad_general');

// RUTA MODIFICADA: Ahora apunta al controlador
Route::get('/usuarios_compatibles', [AstrologicalUserController::class, 'showCompatibleUsers'])->name('usuarios_compatibles');

Route::middleware('auth')->group(function () {

    // Rutas para la funcionalidad de chat
    Route::get('/api/chats/matches', [MatchController::class, 'getActiveMatches'])->name('chats.get_active_matches');
    Route::get('/api/chats/messages/{targetUserId}', [MatchController::class, 'getMessages'])->name('chats.get_messages');
    Route::post('/api/chats/send-message', [MatchController::class, 'sendMessage'])->name('chats.send_message');

    // La ruta para la vista de chat (ya debe existir, solo para referencia)
    Route::get('/chat', function () {
        return view('chat');
    })->name('chat')->middleware('auth');

    // NUEVAS RUTAS PARA IMÁGENES DE PERFIL ADICIONALES
    Route::post('/profile/images/upload', [ProfileImageController::class, 'uploadImage'])->name('profile.images.upload');
    Route::delete('/profile/images/{id}', [ProfileImageController::class, 'deleteImage'])->name('profile.images.delete');

    // ¡NUEVO! Ruta para actualizar los tags del usuario
    Route::post('/profile/tags/update', [AstrologicalUserController::class, 'updateUserTags'])->name('profile.tags.update');
});

Route::middleware('auth')->group(function () {
    // Ruta para obtener los matches potenciales con filtros
    Route::get('/api/matches', [MatchController::class, 'getPotentialMatches'])->name('matches.get');

    // Nueva ruta para obtener las opciones de filtro (géneros, orientaciones, tags)
    Route::get('/api/matches/filter-options', [MatchController::class, 'getFilterOptions'])->name('matches.filter-options');

    // Rutas para procesar las interacciones (like/dislike)
    Route::post('/api/matches/{targetUserId}/interact/{interactionType}', [MatchController::class, 'processInteraction'])->name('matches.interact');

    // La ruta para la vista de matches (ya debe existir, solo para referencia)
    Route::get('/matchs', function () {
        return view('matchs');
    })->name('matchs');

    // Nueva ruta para la pantalla de perfil del match
    Route::get('/matched-profile/{userId}', function ($userId) {
        $user = AstrologicalUser::find($userId);

        if (!$user) {
            // Manejar caso donde el usuario no se encuentra (ej. redirigir a 404 o a la lista de matches)
            return redirect()->route('matchs')->with('error', 'Perfil de usuario no encontrado.');
        }

        return view('matched_profile', compact('user'));
    })->name('matched.profile');
});
