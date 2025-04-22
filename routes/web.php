<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

// Página principal con splash screen
Route::get('/', function () {
    return view('home');
});

// Rutas de usuario
Route::get('/registrar-usuario', [UsuarioController::class, 'create'])->name('usuarios.create');
Route::post('/registrar-usuario', [UsuarioController::class, 'store'])->name('usuarios.store');

