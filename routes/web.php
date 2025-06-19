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
use App\Http\Controllers\ProfileImageController; // NUEVO: Importar el controlador de imágenes

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
    $user = Auth::user();

    // Inicializar variables a null para evitar errores si no se encuentran los datos
    $lunarSign = null;
    $ascendantSign = null;

    // Verificar si el usuario está autenticado y es una instancia de AstrologicalUser
    if ($user instanceof AstrologicalUser) {
        // Cargar las relaciones necesarias para el perfil
        // Añadimos 'imagenesPerfil' para la nueva tarjeta
        $user->load('datosAstralesBasicos.signoSolar', 'groqAstrologyData.signoLunar', 'groqAstrologyData.signoAscendente', 'imagenesPerfil');

        // Acceder a los datos del signo lunar si existen
        if ($user->groqAstrologyData && $user->groqAstrologyData->signoLunar) {
            $lunarSign = $user->groqAstrologyData->signoLunar;
        }

        // Acceder a los datos del signo ascendente si existen
        if ($user->groqAstrologyData && $user->groqAstrologyData->signoAscendente) {
            $ascendantSign = $user->groqAstrologyData->signoAscendente;
        }

        // Despachar los jobs para calcular distancias y compatibilidad en segundo plano
        if (!is_null($user->latitud) && !is_null($user->longitud)) {
            \App\Jobs\CalculateUserDistances::dispatch($user);
            \App\Jobs\CalculateCompatibilityMatches::dispatch($user);
        } else {
            Log::warning('Usuario ' . $user->id . ' no tiene coordenadas para calcular distancias o compatibilidad por proximidad.');
        }
    }

    // Pasar el usuario, el signo lunar, el signo ascendente y las imágenes a la vista 'astromatch'
    return view('astromatch', compact('user', 'lunarSign', 'ascendantSign'));
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
});

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
