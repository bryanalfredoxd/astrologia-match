<?php

namespace App\Http\Controllers;

use App\Models\AstrologicalUser;
use App\Models\SignoZodiacal; // Importa el modelo SignoZodiacal
use App\Models\DatosAstralesBasicos; // Importa el modelo DatosAstralesBasicos
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // Importar la fachada Log
use Carbon\Carbon; // Para trabajar con fechas

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
            'lugar_nacimiento' => 'required|string|max:255', // Sigue validando como string de max 255
            'genero' => 'required|string|in:Masculino,Femenino',
            'orientacion_sexual' => 'required|string|in:Heterosexual,Homosexual,Bisexual,Pansexual,Asexual',
            'terminos_condiciones' => 'required|accepted'
        ]);

        // --- MODIFICACIÓN AQUÍ para lugar_nacimiento ---
        // Obtener la ciudad del input
        $ciudad = $validatedData['lugar_nacimiento'];
        // Concatenar el país
        $lugarNacimientoCompleto = $ciudad . ', Venezuela';
        // --- FIN MODIFICACIÓN ---

        // Creación del usuario
        $user = AstrologicalUser::create([
            'nombre_completo' => $validatedData['nombre_completo'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'fecha_nacimiento' => $validatedData['fecha_nacimiento'],
            'hora_nacimiento' => $validatedData['hora_nacimiento'],
            // Usar la variable con el país concatenado
            'lugar_nacimiento' => $lugarNacimientoCompleto,
            'genero' => $validatedData['genero'],
            'orientacion_sexual' => $validatedData['orientacion_sexual'],
            // 'terminos_condiciones' se valida, pero no se guarda directamente en el modelo por defecto.
            // Si necesitas guardarlo, agrégalo al $fillable de AstrologicalUser y aquí.
        ]);

        // --- Lógica para calcular y guardar el signo solar ---
        $fechaNacimiento = Carbon::parse($validatedData['fecha_nacimiento']);
        $dia = $fechaNacimiento->day;
        $mes = $fechaNacimiento->month;

        $signoSolarNombre = $this->calcularSignoSolar($dia, $mes);

        // Buscar el ID del signo solar en la tabla signos_zodiacales
        $signoSolar = SignoZodiacal::where('nombre_signo', $signoSolarNombre)->first();

        if ($signoSolar) {
            DatosAstralesBasicos::create([
                'id_usuario' => $user->id,
                'id_signo_solar' => $signoSolar->id_signo,
                'id_signo_lunar' => 1, // Placeholder: Asigna un ID temporal (ej. Aries si es el id 1)
                                       // Estos se calcularán más adelante
                'id_ascendente' => 1,  // Placeholder: Asigna un ID temporal
            ]);
        } else {
            // Manejar el caso donde el signo solar no se encuentra (debería existir si la tabla está bien poblada)
            Log::error("Signo solar '$signoSolarNombre' no encontrado en la base de datos.");
        }
        // --- Fin de la lógica para calcular y guardar el signo solar ---


        // Redirección después del registro (puedes cambiarla según tus necesidades)
        // Usamos back() para redirigir a la página anterior o a la ruta de login si no hay anterior
        return redirect()->route('login')->with('success', '¡Registro exitoso! Por favor, inicia sesión.');
    }

    /**
     * Función para calcular el signo solar a partir del día y mes.
     * @param int $day
     * @param int $month
     * @return string
     */
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
        return 'Desconocido'; // En caso de que no caiga en ninguna fecha (raro)
    }
}