<?php

namespace App\Http\Controllers;

use App\Models\AstrologicalUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AstrologicalUserController extends Controller
{
    public function register(Request $request)
    {
        // Validación de los datos del formulario
        $validatedData = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:astrological_users',
            'password' => 'required|string|min:8',
            'fecha_nacimiento' => 'required|date',
            'hora_nacimiento' => 'required',
            'lugar_nacimiento' => 'required|string|max:255',
            'genero' => 'required|string|in:Masculino,Femenino',
            'orientacion_sexual' => 'required|string|in:Heterosexual,Homosexual,Bisexual,Pansexual,Asexual',
        ]);

        // Creación del usuario
        $user = AstrologicalUser::create([
            'nombre_completo' => $validatedData['nombre_completo'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'fecha_nacimiento' => $validatedData['fecha_nacimiento'],
            'hora_nacimiento' => $validatedData['hora_nacimiento'],
            'lugar_nacimiento' => $validatedData['lugar_nacimiento'],
            'genero' => $validatedData['genero'],
            'orientacion_sexual' => $validatedData['orientacion_sexual'],
        ]);

        // Redirección después del registro (puedes cambiarla según tus necesidades)
        return redirect()->route('home')->with('success', '¡Registro exitoso!');
    }
}