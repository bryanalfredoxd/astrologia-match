<?php

namespace App\Http\Controllers;

use App\Models\AstrologicalUser;
use App\Models\SignoZodiacal;
use App\Models\DatosAstralesBasicos;
use App\Models\GroqAstrologyData; // Importa el modelo GroqAstrologyData
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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
            'terminos_condiciones' => 'required|accepted'
        ]);

        // Obtener la ciudad del input y concatenar el país
        $ciudad = $validatedData['lugar_nacimiento'];
        $lugarNacimientoCompleto = $ciudad . ', Venezuela'; //

        // Creación del usuario
        $user = AstrologicalUser::create([
            'nombre_completo' => $validatedData['nombre_completo'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'fecha_nacimiento' => $validatedData['fecha_nacimiento'],
            'hora_nacimiento' => $validatedData['hora_nacimiento'],
            'lugar_nacimiento' => $lugarNacimientoCompleto,
            'genero' => $validatedData['genero'],
            'orientacion_sexual' => $validatedData['orientacion_sexual'],
        ]);

        // Lógica para calcular y guardar el signo solar
        $fechaNacimiento = Carbon::parse($validatedData['fecha_nacimiento']);
        $dia = $fechaNacimiento->day;
        $mes = $fechaNacimiento->month;

        $signoSolarNombre = $this->calcularSignoSolar($dia, $mes);
        $signoSolar = SignoZodiacal::where('nombre_signo', $signoSolarNombre)->first(); //

        if ($signoSolar) {
            DatosAstralesBasicos::create([
                'id_usuario' => $user->id,
                'id_signo_solar' => $signoSolar->id_signo,
            ]);
        } else {
            Log::error("Signo solar '$signoSolarNombre' no encontrado en la base de datos."); //
            // Opcional: manejar el error, como devolver un mensaje al usuario o lanzar una excepción.
        }

        // Aquí podrías crear un registro en groq_astrology_data si es necesario,
        // aunque es nullable y podrías llenarlo más tarde.
        // Si quieres crearlo vacío al registrar el usuario:
        GroqAstrologyData::create([
            'user_id' => $user->id,
            // 'signo_lunar_id' y 'signo_ascendente_id' son nullable, se pueden dejar vacíos
        ]);


        return redirect()->route('login')->with('success', '¡Registro exitoso! Por favor, inicia sesión.'); //
    }

    private function calcularSignoSolar($day, $month)
    {
        if (($month == 3 && $day >= 21) || ($month == 4 && $day <= 19)) return 'Aries';
        if (($month == 4 && $day >= 20) || ($month == 5 && $day <= 20)) return 'Tauro';
        if (($month == 5 && $day >= 21) || ($month == 6 && $day <= 20)) return 'Géminis';
        if (($month == 6 && $day >= 21) || ($month == 7 && $day <= 22)) return 'Cáncer';
        if (($month == 7 && $day >= 23) || ($month == 8 && $day <= 22)) return 'Leo';
        if (($month == 8 && $day >= 23) || ($month == 9 && $day <= 22)) return 'Virgo';
        if (($month == 9 && $day >= 23) || ($month == 10 && $day <= 22)) return 'Libra';
        if (($month == 10 && $day >= 23) || ($month == 11 && $day <= 21)) return 'Escorpio';
        if (($month == 11 && $day >= 22) || ($month == 12 && $day <= 21)) return 'Sagitario';
        if (($month == 12 && $day >= 22) || ($month == 1 && $day <= 19)) return 'Capricornio';
        if (($month == 1 && $day >= 20) || ($month == 2 && $day <= 18)) return 'Acuario';
        if (($month == 2 && $day >= 19) || ($month == 3 && $day <= 20)) return 'Piscis';
        return 'Desconocido'; //
    }

    public function update(Request $request)
    {
        /** @var \App\Models\AstrologicalUser $user */
        $user = Auth::user();
        
        $validated = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:astrological_users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'genero' => 'required|string|max:50',
            'orientacion_sexual' => 'required|string|max:50',
            'latitud' => 'nullable|numeric|between:-90,90',
            'longitud' => 'nullable|numeric|between:-180,180',
            'biografia' => 'nullable|string|max:1000',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Actualizar campos básicos
        $user->nombre_completo = $validated['nombre_completo'];
        $user->email = $validated['email'];
        $user->genero = $validated['genero'];
        $user->orientacion_sexual = $validated['orientacion_sexual'];
        $user->latitud = $validated['latitud'];
        $user->longitud = $validated['longitud'];
        $user->biografia = $validated['biografia'];

        // Actualizar contraseña si se proporcionó
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // Manejar la imagen de perfil
        if ($request->hasFile('foto_perfil')) {
            if ($user->foto_perfil_url) {
                Storage::delete($user->foto_perfil_url);
            }
            
            $path = $request->file('foto_perfil')->store('profile-photos');
            $user->foto_perfil_url = $path;
        }

        $user->save();

        return redirect()->route('astromatch')->with('success', 'Perfil actualizado correctamente.');
    }

}