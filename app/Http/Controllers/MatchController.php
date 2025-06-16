<?php

namespace App\Http\Controllers;

use App\Models\AstrologicalUser;
use App\Models\Compatibilidad;
use App\Models\UserDistance;
use App\Models\InteraccionPerfil;
use App\Models\Emparejamientos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon; // Para calcular la edad

class MatchController extends Controller
{
    /**
     * Obtiene y devuelve una lista de usuarios compatibles para el usuario actual.
     * Los resultados se ordenan por proximidad geográfica y luego por puntuación de compatibilidad astrológica.
     * Se excluyen los usuarios con los que ya se ha interactuado (like/dislike).
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPotentialMatches(Request $request)
    {
        $currentUser = Auth::user();

        if (!$currentUser) {
            return response()->json(['error' => 'Usuario no autenticado.'], 401);
        }

        // Obtener IDs de usuarios con los que ya se ha interactuado (like o dislike)
        // No incluyas 'vista' aquí, ya que ver un perfil no debería excluirlo permanentemente
        $interactedUserIds = InteraccionPerfil::where('id_emisor', $currentUser->id)
                                             ->whereIn('tipo_interaccion', ['like', 'dislike'])
                                             ->pluck('id_receptor')
                                             ->toArray();

        // Obtener todos los registros de compatibilidad donde el usuario actual es uno de los dos usuarios
        // y la puntuación astrológica ya ha sido calculada.
        $compatibilities = Compatibilidad::where(function ($query) use ($currentUser) {
            $query->where('id_usuario1', $currentUser->id)
                  ->orWhere('id_usuario2', $currentUser->id);
        })
        ->whereNotNull('puntuacion_general') // Asegurar que la compatibilidad astrológica esté calculada
        ->get();

        $potentialMatches = collect();

        foreach ($compatibilities as $compat) {
            // Identificar al "otro usuario" en el par de compatibilidad
            $otherUserId = ($compat->id_usuario1 === $currentUser->id) ? $compat->id_usuario2 : $compat->id_usuario1;

            // Excluir al usuario consigo mismo y usuarios ya interactuados
            if ($otherUserId === $currentUser->id || in_array($otherUserId, $interactedUserIds)) {
                continue;
            }

            // Obtener el objeto del "otro usuario"
            $otherUser = AstrologicalUser::find($otherUserId);

            if (!$otherUser) {
                Log::warning("Usuario con ID {$otherUserId} no encontrado en getPotentialMatches, omitiendo.");
                continue; // Saltar si el usuario no existe (ej. eliminado)
            }

            // Obtener la distancia geográfica
            // Asegurarse de que el orden de los IDs sea el mismo que en user_distances (menor primero)
            $distanceRecord = UserDistance::where(function ($query) use ($currentUser, $otherUser) {
                $query->where('id_usuario1', min($currentUser->id, $otherUser->id))
                      ->where('id_usuario2', max($currentUser->id, $otherUser->id));
            })->first();

            $distance = $distanceRecord ? $distanceRecord->distancia_km : null;

            // Si la distancia es nula o mayor a 50km, omitir (este filtro ya lo hacen los Jobs, pero se refuerza aquí)
            if (is_null($distance) || $distance > 50) {
                continue;
            }

            // Calcular la edad
            $edad = null;
            if ($otherUser->fecha_nacimiento) {
                try {
                    $edad = Carbon::parse($otherUser->fecha_nacimiento)->age;
                } catch (\Exception $e) {
                    Log::error("Error calculando edad para usuario {$otherUser->id}: " . $e->getMessage());
                }
            }


            // Añadir el match a la colección
            $potentialMatches->push([
                'id' => $otherUser->id,
                'compatibilidad_id' => $compat->id_compatibilidad,
                'nombre_completo' => $otherUser->nombre_completo,
                'edad' => $edad,
                'biografia' => $otherUser->biografia,
                'foto_perfil_url' => $otherUser->foto_perfil_url,
                'lugar_nacimiento' => $otherUser->lugar_nacimiento,
                'genero' => $otherUser->genero,
                'orientacion_sexual' => $otherUser->orientacion_sexual,
                'puntuacion_general' => $compat->puntuacion_general,
                'descripcion_breve' => $compat->descripcion_breve,
                'analisis_detallado' => $compat->analisis_detallado,
                'distancia_km' => $distance,
            ]);
        }

        // Ordenar primero por distancia (ascendente) y luego por puntuación general (descendente)
        $sortedMatches = $potentialMatches->sortBy('distancia_km')->sortByDesc('puntuacion_general')->values();

        return response()->json(['matches' => $sortedMatches]);
    }

    /**
     * Procesa una interacción de perfil (like/dislike).
     *
     * @param Request $request
     * @param int $targetUserId El ID del usuario con el que se interactúa.
     * @param string $interactionType El tipo de interacción ('like' o 'dislike').
     * @return \Illuminate\Http\JsonResponse
     */
    public function processInteraction(Request $request, int $targetUserId, string $interactionType)
    {
        $currentUser = Auth::user();

        if (!$currentUser) {
            return response()->json(['message' => 'Usuario no autenticado.'], 401);
        }

        if (!in_array($interactionType, ['like', 'dislike'])) {
            return response()->json(['message' => 'Tipo de interacción no válido.'], 400);
        }

        // Prevenir auto-interacción
        if ($currentUser->id === $targetUserId) {
            return response()->json(['message' => 'No puedes interactuar contigo mismo.'], 400);
        }

        // Crear o actualizar la interacción
        InteraccionPerfil::updateOrCreate(
            [
                'id_emisor' => $currentUser->id,
                'id_receptor' => $targetUserId,
                'tipo_interaccion' => $interactionType,
            ],
            [
                'fecha_interaccion' => now(), // Actualiza la fecha si ya existía
            ]
        );

        Log::info("Usuario {$currentUser->id} {$interactionType} a Usuario {$targetUserId}.");

        $isMatch = false;
        $message = "Interacción registrada.";

        if ($interactionType === 'like') {
            // Verificar si el otro usuario también le dio "like" al usuario actual
            $mutualLike = InteraccionPerfil::where('id_emisor', $targetUserId)
                                           ->where('id_receptor', $currentUser->id)
                                           ->where('tipo_interaccion', 'like')
                                           ->exists();

            if ($mutualLike) {
                // Crear el emparejamiento (match)
                // Asegurarse de que el orden de los IDs sea el menor primero para unicidad
                $id1 = min($currentUser->id, $targetUserId);
                $id2 = max($currentUser->id, $targetUserId);

                Emparejamientos::updateOrCreate(
                    [
                        'usuario1_id' => $id1,
                        'usuario2_id' => $id2,
                    ],
                    [
                        'estado' => 'activo',
                        'fecha_emparejamiento' => now(),
                    ]
                );
                $isMatch = true;
                $message = "¡Es un Match! Ambos se gustaron.";
                Log::info("¡MATCH! entre U{$currentUser->id} y U{$targetUserId}.");
            }
        }

        return response()->json(['message' => $message, 'is_match' => $isMatch]);
    }
}
