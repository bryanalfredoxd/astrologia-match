<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => [
                'required',
                'regex:/^[\pL\s]+$/u', // solo letras y espacios
                'max:100'
            ],
            'apellido' => [
                'required',
                'regex:/^[\pL\s]+$/u',
                'max:100'
            ],
            'email' => 'required|email|unique:usuarios,email',
            'contrasena' => 'required|string|min:8|confirmed',
            'fecha_nacimiento' => ['required', 'date', function ($attribute, $value, $fail) {
                if (\Carbon\Carbon::parse($value)->age < 18) {
                    $fail('Debes tener al menos 18 años para registrarte.');
                }
            }],
            'genero' => 'required|in:Masculino,Femenino,Otro',
            'terms' => 'required|accepted'
        ], [
            'nombre.required' => 'El campo nombre es obligatorio',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios',
            'apellido.required' => 'El campo apellido es obligatorio',
            'apellido.regex' => 'El apellido solo puede contener letras y espacios',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'Ingresa un correo electrónico válido',
            'email.unique' => 'Este correo electrónico ya está registrado',
            'contrasena.required' => 'La contraseña es obligatoria',
            'contrasena.min' => 'La contraseña debe tener al menos 8 caracteres',
            'contrasena.confirmed' => 'Las contraseñas no coinciden',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria',
            'genero.required' => 'Debes seleccionar un género',
            'genero.in' => 'Género no válido',
            'terms.required' => 'Debes aceptar los términos y condiciones',
            'terms.accepted' => 'Debes aceptar los términos y condiciones'
        ]);
    
        Usuario::create([
            'nombre' => $validatedData['nombre'],
            'apellido' => $validatedData['apellido'],
            'email' => $validatedData['email'],
            'contrasena' => bcrypt($validatedData['contrasena']),
            'fecha_nacimiento' => $validatedData['fecha_nacimiento'],
            'genero' => $validatedData['genero'],
        ]);
    
        return redirect()->back()->with('success', '¡Registro exitoso! Bienvenido a AstroMatch');
    }
    
}
