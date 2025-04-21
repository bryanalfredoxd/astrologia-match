<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

use App\Http\Controllers\UsuarioController;

Route::get('/registrar-usuario', [UsuarioController::class, 'create'])->name('usuarios.create');
Route::post('/registrar-usuario', [UsuarioController::class, 'store'])->name('usuarios.store');

