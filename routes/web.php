<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AstrologicalUserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Models\AstrologicalUser; // Asegúrate de importar el modelo
use App\Http\Controllers\GroqAstrologyController;
use App\Jobs\CalculateUserDistances; // Ya lo tienes
use App\Jobs\CalculateCompatibilityMatches; // ¡Añade esta línea!
use Illuminate\Support\Facades\Log; // Para el Log::warning en la ruta
use App\Http\Controllers\MatchController;

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
Route::get('/astromatch', function () {
    // Obtener el usuario autenticado
    $user = Auth::user(); // Esto obtendrá el objeto AstrologicalUser del usuario logueado

    // Verificar si el usuario está autenticado y es una instancia de AstrologicalUser
    if ($user instanceof AstrologicalUser) {
        // Si el usuario es de tipo AstrologicalUser, carga las relaciones
        $user->load('datosAstralesBasicos.signoSolar');

        // *** AÑADIR ESTA LÍNEA PARA DESPACHAR EL JOB ***
        // Despachar el job para calcular las distancias en segundo plano
        // Se asegura de que el usuario tenga latitud y longitud antes de despachar
        if (!is_null($user->latitud) && !is_null($user->longitud)) {
            \App\Jobs\CalculateUserDistances::dispatch($user);
            \App\Jobs\CalculateCompatibilityMatches::dispatch($user); // ¡Nuevo Job aquí!
        } else {
            Log::warning('Usuario ' . $user->id . ' no tiene coordenadas para calcular distancias o compatibilidad por proximidad.');
        }
    }

    // Pasar el usuario a la vista 'astromatch'
    return view('astromatch', compact('user'));
})->name('astromatch')->middleware('auth');


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

Route::get('/usuarios_compatibles', function () {
    return view('others.usuario_compatibles');
})->name('usuarios_compatibles');

Route::get('/chat', function () {
    return view('chat');
})->name('chat')->middleware('auth');

Route::middleware('auth')->group(function () {
    // Ruta para obtener los matches potenciales
    Route::get('/api/matches', [MatchController::class, 'getPotentialMatches'])->name('matches.get');

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
