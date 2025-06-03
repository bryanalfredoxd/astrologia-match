<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AstrologicalUserController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;

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

    // Pasar el usuario a la vista 'astromatch'
    return view('astromatch', compact('user'));
})->name('astromatch')->middleware('auth');


Route::post('/register', [AstrologicalUserController::class, 'register'])->name('register.submit');
