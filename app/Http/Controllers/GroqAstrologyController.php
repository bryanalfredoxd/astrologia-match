<?php 

namespace App\Http\Controllers; // <--- Esta debe ser la primera declaración después de <?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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

        // 2. Preparar el prompt para la API de Groq
        $prompt = "Calcula el signo lunar y ascendente (rising sign) de la siguiente persona, basándote en la astrología occidental y un enfoque general (no necesito precisión milimétrica, solo una estimación):" .
                  "\n- Nombre: " . $validatedData['nombre_completo'] .
                  "\n- Fecha de Nacimiento: " . $validatedData['fecha_nacimiento'] .
                  "\n- Hora de Nacimiento: " . $validatedData['hora_nacimiento'] .
                  "\n- Lugar de Nacimiento: " . $validatedData['lugar_nacimiento'] .
                  "\n- Género: " . $validatedData['genero'] .
                  "\nPor favor, responde de forma concisa con el signo lunar y ascendente." .
                  "\nFormato de respuesta: \nSigno Lunar: [Signo]\nAscendente: [Signo]";

        // 3. Realizar la llamada a la API de Groq
        $groqApiKey = env('GROQ_API_KEY'); // Obtén tu API Key del archivo .env

        if (!$groqApiKey) {
            Log::error('GROQ_API_KEY no está configurada en el archivo .env');
            return response()->json(['error' => 'La API Key de Groq no está configurada.'], 500);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $groqApiKey,
                'Content-Type' => 'application/json',
            ])->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'llama3-8b-8192', // Puedes elegir otro modelo si lo prefieres, como 'mixtral-8x7b-32768' o 'gemma-7b-it'
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres un astrólogo experto y amigable que puede dar interpretaciones básicas de cartas natales.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'temperature' => 0.7, // Ajusta la creatividad de la respuesta
                'max_tokens' => 300, // Limita la longitud de la respuesta
            ])->json();

            // 4. Procesar la respuesta de Groq
            $astrologyText = $response['choices'][0]['message']['content'] ?? 'No se pudo obtener una respuesta de la IA.';

            // Puedes intentar parsear el texto para extraer el signo lunar y ascendente si quieres guardarlos por separado
            // Por ahora, lo pasaremos como texto plano para la demostración
            return response()->json(['astrology_data' => $astrologyText]);

        } catch (\Exception $e) {
            Log::error('Error al llamar a la API de Groq: ' . $e->getMessage());
            return response()->json(['error' => 'Error al comunicarse con la IA.'], 500);
        }
    }

    public function showResponse()
    {
        // Recuperar la respuesta de Groq del localStorage
        // En una aplicación real, esto podría ser un endpoint de la API que devuelva los datos del usuario
        // o que los guarde en la DB y luego los muestre. Para la prueba, localStorage es suficiente.
        return view('groq-response');
    }
}