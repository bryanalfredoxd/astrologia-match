<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\SignoZodiacal; // Importar el modelo SignoZodiacal
use App\Models\GroqAstrologyData; // Importar el modelo GroqAstrologyData
use Illuminate\Support\Facades\Auth; // Para obtener el ID del usuario autenticado

class GroqAstrologyController extends Controller
{
    public function calculateAstrology(Request $request)
    {
        // 1. Validar los datos recibidos del frontend
        $validatedData = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'hora_nacimiento' => 'required',
            'lugar_nacimiento' => 'required|string|max:255',
            'genero' => 'required|string|in:Masculino,Femenino',
        ]);

        // Obtener el ID del usuario autenticado
        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['error' => 'Usuario no autenticado.'], 401);
        }

        // 2. Preparar el prompt para la API de Groq
        $prompt = "Calcula el signo lunar y ascendente (rising sign) de la siguiente persona, basándote en la astrología occidental y un enfoque general (no necesito precisión milimétrica, solo una estimación):" .
                  "\n- Nombre: " . $validatedData['nombre_completo'] .
                  "\n- Fecha de Nacimiento: " . $validatedData['fecha_nacimiento'] .
                  "\n- Hora de Nacimiento: " . $validatedData['hora_nacimiento'] .
                  "\n- Lugar de Nacimiento: " . $validatedData['lugar_nacimiento'] .
                  "\n- Género: " . $validatedData['genero'] .
                  "\nY ten en cuenta para la respuesta que quiero: Los signos los tengo asociados con numeros, es decir 1: Aries, 2: Tauro, 3: Géminis, 4: Cáncer, 5: Leo, 6: Virgo, 7: Libra, 8: Escorpio, 9: Sagitario, 10: Capricornio, 11: Acuario, 12: Piscis." .
                  "\nPor favor, responde de forma concisa con el signo lunar y ascendente. Y verifica que estas aignando bien el numero correspondiente al signo, ya que son del 1 al 12 no hay mas opciones" .
                  "\nFormato de respuesta: \nSigno Lunar: [Numero] - [Signo]\nAscendente: [Numero] - [Signo]";

        // 3. Realizar la llamada a la API de Groq
        $groqApiKey = env('GROQ_API_KEY');

        if (!$groqApiKey) {
            Log::error('GROQ_API_KEY no está configurada en el archivo .env');
            return response()->json(['error' => 'La API Key de Groq no está configurada.'], 500);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $groqApiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama3-8b-8192',
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres un astrólogo experto y amigable que puede dar interpretaciones básicas de cartas natales.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.7,
                'max_tokens' => 300,
            ])->json();

            // 4. Procesar la respuesta de Groq
            $astrologyText = $response['choices'][0]['message']['content'] ?? 'No se pudo obtener una respuesta de la IA.';

            $signoLunarId = null;
            $signoAscendenteId = null;

            // Expresiones regulares para extraer el número del signo
            if (preg_match('/Signo Lunar: (\d+) -/', $astrologyText, $matchesLunar)) {
                $numeroSignoLunar = $matchesLunar[1];
                $signoLunar = SignoZodiacal::where('id_signo', $numeroSignoLunar)->first();
                if ($signoLunar) {
                    $signoLunarId = $signoLunar->id_signo;
                }
            }

            if (preg_match('/Ascendente: (\d+) -/', $astrologyText, $matchesAscendente)) {
                $numeroAscendente = $matchesAscendente[1];
                $signoAscendente = SignoZodiacal::where('id_signo', $numeroAscendente)->first();
                if ($signoAscendente) {
                    $signoAscendenteId = $signoAscendente->id_signo;
                }
            }

            // Guardar o actualizar los datos en la tabla groq_astrology_data
            GroqAstrologyData::updateOrCreate(
                ['user_id' => $userId],
                [
                    'signo_lunar_id' => $signoLunarId,
                    'signo_ascendente_id' => $signoAscendenteId,
                ]
            );

            return response()->json(['astrology_data' => $astrologyText]);

        } catch (\Exception $e) {
            Log::error('Error al llamar a la API de Groq: ' . $e->getMessage());
            return response()->json(['error' => 'Error al comunicarse con la IA.'], 500);
        }
    }

    public function showResponse()
    {
        return view('groq-response');
    }
}