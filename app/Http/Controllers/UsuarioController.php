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
        $request->validate([
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
        ]);
    
        Usuario::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'contrasena' => bcrypt($request->contrasena),
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'genero' => $request->genero,
        ]);
    
        return redirect()->back()->with('success', 'Usuario registrado correctamente');
    }
    
}
