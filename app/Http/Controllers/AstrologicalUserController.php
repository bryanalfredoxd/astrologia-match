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
            // Eliminar la foto de perfil antigua si existe y es una URL pública
                        if ($user->foto_perfil_url && \Illuminate\Support\Str::startsWith($user->foto_perfil_url, 'images/upload/img_user/')) {
                $oldImagePath = public_path($user->foto_perfil_url);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Eliminar el archivo físico
                }
            }

            $image = $request->file('foto_perfil');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('images/upload/img_user');

            // Asegurarse de que el directorio exista
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true); // Crear directorio con permisos
            }

            // Mover la imagen al directorio público
            $image->move($destinationPath, $imageName);

            // Guardar la ruta relativa pública en la base de datos
            $user->foto_perfil_url = 'images/upload/img_user/' . $imageName;
        }

        $user->save();

        return redirect()->route('astromatch')->with('success', 'Perfil actualizado correctamente.');
    }

    /**
     * Muestra el número de usuarios compatibles basado en los parámetros de la solicitud.
     */
    public function showCompatibleUsers(Request $request)
    {
        // Validación de los parámetros recibidos del formulario
        $validatedData = $request->validate([
            'signo' => 'required|string|max:50',
            'genero' => 'required|string|in:masculino,femenino',
            'orientacion' => 'required|string|in:heterosexual,homosexual,bisexual',
            'busca' => 'required|string|in:hombres,mujeres,ambos',
            'edad' => 'required|integer|min:18|max:100',
        ]);

        $signoNombre = $validatedData['signo'];
        $generoUsuario = $validatedData['genero'];
        $orientacionUsuario = $validatedData['orientacion'];
        $buscaGenero = $validatedData['busca'];
        $edadUsuario = $validatedData['edad'];

        // Obtener el ID del signo zodiacal del usuario actual basado en el nombre
        $signoId = SignoZodiacal::where('nombre_signo', $signoNombre)->value('id_signo');

        if (!$signoId) {
            // Manejar el caso donde el signo no se encuentra (debería existir si el formulario es validado)
            return redirect()->back()->with('error', 'Signo zodiacal no encontrado.');
        }

        // Construir la consulta para encontrar usuarios compatibles
        $query = AstrologicalUser::query();

        // 1. Filtrar por signo zodiacal (usando la tabla pivot datos_astrales_basicos)
        $query->whereHas('datosAstralesBasicos', function ($q) use ($signoId) {
            $q->where('id_signo_solar', $signoId);
        });

        // 2. Filtrar por género y "busca"
        // Si el usuario busca hombres, y su orientación es homosexual o bisexual, busca hombres.
        // Si el usuario busca mujeres, y su orientación es heterosexual o bisexual, busca mujeres.
        // Si el usuario busca ambos, entonces busca hombres y mujeres.

        // Convertir los valores de 'genero' y 'busca' a los que están en la base de datos
        // Asumiendo que en DB 'genero' es 'Masculino' o 'Femenino' (capitalizado)
        $generoDB = ($generoUsuario === 'masculino') ? 'Masculino' : 'Femenino';

        // Lógica para 'busca':
        if ($buscaGenero === 'hombres') {
            $query->where('genero', 'Masculino');
        } elseif ($buscaGenero === 'mujeres') {
            $query->where('genero', 'Femenino');
        }
        // Si busca 'ambos', no filtramos por género aquí, ya que incluimos ambos.

        // 3. Filtrar por orientación sexual del usuario compatible
        // Aquí la lógica puede ser más compleja y depender de cómo defines la compatibilidad.
        // Por ejemplo, un heterosexual busca heterosexuales del género opuesto.
        // Un homosexual busca homosexuales del mismo género.
        // Un bisexual puede buscar de ambas orientaciones.

        // Por simplicidad, solo filtramos por la orientación sexual del 'target'
        // que es compatible con la orientación y búsqueda del usuario.

        // Ejemplo simple: Si el usuario es heterosexual y busca mujeres, la mujer debe ser heterosexual o bisexual.
        // Esto es una simplificación, la compatibilidad sexual real es más matizada.

        // Para esta implementación básica, vamos a buscar usuarios que se "buscan" mutuamente
        // o que su orientación los hace compatibles con la búsqueda del otro.

        // Por ahora, solo usaremos los parámetros del formulario para buscar usuarios con esas características.
        // Por ejemplo, si el usuario es "masculino", "heterosexual" y busca "mujeres" de "Aries" de "25" años:
        // Buscamos mujeres, que sean Aries, y con una edad cercana.

        // La siguiente parte asume que queremos encontrar usuarios que coincidan con la *descripción* del perfil
        // que el usuario está buscando. No es una compatibilidad mutua.
        // Si quiero buscar a hombres:
        // $query->where('genero', 'Masculino');
        // $query->where('orientacion_sexual', 'Heterosexual'); // (Si el que busca es mujer)
        // $query->where('orientacion_sexual', 'Homosexual'); // (Si el que busca es hombre)
        // Esto es donde se complica la lógica de emparejamiento real.

        // Para este ejercicio, vamos a buscar usuarios que *coincidan con los criterios deseados por el que busca*.
        // Por ejemplo, si el usuario dice que "busca" "hombres", filtraremos por 'genero' = 'Masculino'.
        // Si el usuario dice que su 'orientacion' es 'heterosexual' y 'busca' 'mujeres',
        // entonces buscaremos mujeres cuya 'orientacion_sexual' sea 'heterosexual' o 'bisexual'.

        // Si 'busca' es 'hombres':
        if ($buscaGenero === 'hombres') {
            $query->where('genero', 'Masculino');
            // Si el usuario es heterosexual y busca hombres, no es compatible con hombres heterosexuales.
            // Si el usuario es homosexual y busca hombres, busca hombres homosexuales o bisexuales.
            if ($orientacionUsuario === 'homosexual') {
                $query->whereIn('orientacion_sexual', ['Homosexual', 'Bisexual', 'Pansexual']);
            } elseif ($orientacionUsuario === 'bisexual') {
                // Un bisexual que busca hombres, puede buscar homosexuales o bisexuales
                 $query->whereIn('orientacion_sexual', ['Homosexual', 'Bisexual', 'Pansexual']);
            } else { // Heterosexual o Asexual buscando hombres (menos común en apps de citas, pero posible)
                 // Puedes decidir si los heterosexuales buscan hombres (serían mujeres)
                 // o si es un error lógico para la búsqueda.
                 // Para un hombre heterosexual buscando hombres, no habría compatibilidad.
                 // Para una mujer heterosexual buscando hombres, buscariamos hombres heterosexuales o bisexuales.
                if ($generoUsuario === 'femenino') { // Una mujer heterosexual buscando hombres
                     $query->whereIn('orientacion_sexual', ['Heterosexual', 'Bisexual', 'Pansexual']);
                }
            }
        }
        // Si 'busca' es 'mujeres':
        elseif ($buscaGenero === 'mujeres') {
            $query->where('genero', 'Femenino');
            if ($orientacionUsuario === 'heterosexual') {
                $query->whereIn('orientacion_sexual', ['Heterosexual', 'Bisexual', 'Pansexual']);
            } elseif ($orientacionUsuario === 'bisexual') {
                $query->whereIn('orientacion_sexual', ['Heterosexual', 'Bisexual', 'Pansexual']);
            } else { // Homosexual o Asexual buscando mujeres
                if ($generoUsuario === 'masculino') { // Un hombre homosexual buscando mujeres (raro)
                    // Podrías no encontrar resultados aquí si la lógica es estricta.
                } elseif ($generoUsuario === 'femenino') { // Una mujer homosexual buscando mujeres
                    $query->whereIn('orientacion_sexual', ['Homosexual', 'Bisexual', 'Pansexual']);
                }
            }
        }
        // Si 'busca' es 'ambos':
        elseif ($buscaGenero === 'ambos') {
            // Si el usuario es heterosexual, busca el género opuesto con orientaciones compatibles.
            // Si el usuario es homosexual, busca el mismo género con orientaciones compatibles.
            // Si el usuario es bisexual, busca ambos géneros con orientaciones compatibles.

            $query->where(function ($q) use ($generoUsuario, $orientacionUsuario) {
                if ($orientacionUsuario === 'heterosexual') {
                    // Si el usuario es hombre heterosexual, busca mujeres heterosexuales/bisexuales.
                    // Si el usuario es mujer heterosexual, busca hombres heterosexuales/bisexuales.
                    if ($generoUsuario === 'masculino') { // Hombre heterosexual busca mujeres
                        $q->where('genero', 'Femenino')
                          ->whereIn('orientacion_sexual', ['Heterosexual', 'Bisexual', 'Pansexual']);
                    } else { // Mujer heterosexual busca hombres
                        $q->where('genero', 'Masculino')
                          ->whereIn('orientacion_sexual', ['Heterosexual', 'Bisexual', 'Pansexual']);
                    }
                } elseif ($orientacionUsuario === 'homosexual') {
                    // Si el usuario es hombre homosexual, busca hombres homosexuales/bisexuales.
                    // Si el usuario es mujer homosexual, busca mujeres homosexuales/bisexuales.
                    if ($generoUsuario === 'masculino') { // Hombre homosexual busca hombres
                        $q->where('genero', 'Masculino')
                          ->whereIn('orientacion_sexual', ['Homosexual', 'Bisexual', 'Pansexual']);
                    } else { // Mujer homosexual busca mujeres
                        $q->where('genero', 'Femenino')
                          ->whereIn('orientacion_sexual', ['Homosexual', 'Bisexual', 'Pansexual']);
                    }
                } elseif ($orientacionUsuario === 'bisexual') {
                    // Un bisexual puede buscar tanto hombres como mujeres con orientaciones que los incluyan.
                    $q->where(function($subQ) {
                        $subQ->where('genero', 'Masculino')
                             ->whereIn('orientacion_sexual', ['Heterosexual', 'Homosexual', 'Bisexual', 'Pansexual']);
                    })->orWhere(function($subQ) {
                        $subQ->where('genero', 'Femenino')
                             ->whereIn('orientacion_sexual', ['Heterosexual', 'Homosexual', 'Bisexual', 'Pansexual']);
                    });
                }
            });
        }


        // 4. Filtrar por edad
        // Podrías querer un rango de edad, por ejemplo, +/- 5 años de la edad del usuario.
        $minEdad = max(18, $edadUsuario - 5);
        $maxEdad = min(100, $edadUsuario + 5);

        // Calculate age based on fecha_nacimiento
        $query->whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) BETWEEN ? AND ?', [$minEdad, $maxEdad]);


        // Excluir al propio usuario si está autenticado
        if (Auth::check()) {
            $query->where('id', '!=', Auth::id());
        }

        // Obtener el total de usuarios compatibles
        $totalCompatibles = $query->count();

        // Pasar el total a la vista
        return view('others.usuario_compatibles', compact('totalCompatibles'));
    }
}