<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;

// Página principal con splash screen
Route::get('/', function () {
    return view('home');
});

// Rutas de usuario
Route::get('/registro', function () {
    return view('registro');
})->name('register');

