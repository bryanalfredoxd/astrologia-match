<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AstrologicalUserController;
use App\Http\Controllers\AuthController;

// Página principal con splash screen
Route::get('/', function () {
    return auth()->guard()->check() ? redirect()->route('astromatch') : view('home');
})->name('home');

Route::get('/register', function () {
    return view('auth.registro'); 
})->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Ruta de inicio de sesión
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Ruta de cierre de sesión
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Ruta protegida (requiere autenticación)
Route::get('/astromatch', function () {
    return view('astromatch');
})->name('astromatch')->middleware('auth');



Route::post('/register', [AstrologicalUserController::class, 'register'])->name('register.submit');
