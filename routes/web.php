<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\AstrologicalUserController;

// Página principal con splash screen
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/register', function () {
    return view('auth.registro'); // Reemplaza con tu vista actual
})->name('register');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/astromatch', function () {
    return view('astromatch');
})->name('astromatch');



Route::post('/register', [AstrologicalUserController::class, 'register'])->name('register.submit');
