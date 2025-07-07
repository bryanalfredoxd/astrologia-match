<?php

namespace App\Http\Controllers;

use App\Models\AstrologicalUser;
use App\Models\Compatibilidad;
use App\Models\UserDistance;
use App\Models\InteraccionPerfil;
use App\Models\Emparejamientos; // Modelo de emparejamientos
use App\Models\Mensaje; // Modelo de mensajes
use App\Models\TagMaestro; // Importar el modelo TagMaestro
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

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

            // Obtener el objeto del "otro usuario" con las relaciones astrológicas eager loaded
            // y la relación de imágenes de perfil adicionales.
            $otherUser = AstrologicalUser::with([
                'datosAstralesBasicos.signoSolar',
                'groqAstrologyData.signoLunar',
                'groqAstrologyData.signoAscendente',
                'imagenesPerfil', // Cargar las imágenes de perfil adicionales
                'usuarioTags.tagMaestro' // Cargar los tags del usuario
            ])->find($otherUserId);

            if (!$otherUser) {
                Log::warning("Usuario con ID {$otherUserId} no encontrado en getPotentialMatches, omitiendo.");
                continue; // Saltar si el usuario no existe (ej. eliminado)
            }

            // Aplicar filtros adicionales de la solicitud
            // Edad
            $minAgeFilter = $request->input('age_min');
            $maxAgeFilter = $request->input('age_max');
            if ($minAgeFilter && $otherUser->fecha_nacimiento) {
                $age = Carbon::parse($otherUser->fecha_nacimiento)->age;
                if ($age < $minAgeFilter) {
                    continue;
                }
            }
            if ($maxAgeFilter && $otherUser->fecha_nacimiento) {
                $age = Carbon::parse($otherUser->fecha_nacimiento)->age;
                if ($age > $maxAgeFilter) {
                    continue;
                }
            }

            // Género
            $generoFilter = $request->input('genero');
            if ($generoFilter && $otherUser->genero !== $generoFilter) {
                continue;
            }

            // Orientación Sexual
            $orientacionSexualFilter = $request->input('orientacion_sexual');
            if ($orientacionSexualFilter && $otherUser->orientacion_sexual !== $orientacionSexualFilter) {
                continue;
            }

            // Tags
            $tagIdsFilter = $request->input('tag_ids');
            if (!empty($tagIdsFilter)) {
                $otherUserTagIds = $otherUser->usuarioTags->pluck('id_tag')->toArray();
                $hasAllRequiredTags = true;
                foreach ($tagIdsFilter as $tagId) {
                    if (!in_array((int)$tagId, $otherUserTagIds)) {
                        $hasAllRequiredTags = false;
                        break;
                    }
                }
                if (!$hasAllRequiredTags) {
                    continue;
                }
            }


            // Obtener la distancia geográfica
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
                    Log::error("Error al calcular la edad para el usuario ID {$otherUser->id}: " . $e->getMessage());
                }
            }

            // Preparar los datos astrológicos para el JSON
            $solarSign = $otherUser->datosAstralesBasicos->signoSolar ?? null;
            $lunarSign = $otherUser->groqAstrologyData->signoLunar ?? null;
            $ascendantSign = $otherUser->groqAstrologyData->signoAscendente ?? null;

            // Preparar las URLs de las imágenes de perfil adicionales
            $additionalImages = $otherUser->imagenesPerfil->map(function($image) {
                return ['url_imagen' => $image->url_imagen, 'orden' => $image->orden];
            })->sortBy('orden')->values()->all(); // Asegurar que estén ordenadas

            $potentialMatches->push([
                'id' => $otherUser->id,
                'nombre_completo' => $otherUser->nombre_completo,
                'email' => $otherUser->email,
                'fecha_nacimiento' => $otherUser->fecha_nacimiento,
                'edad' => $edad,
                'lugar_nacimiento' => $otherUser->lugar_nacimiento,
                'genero' => $otherUser->genero,
                'orientacion_sexual' => $otherUser->orientacion_sexual,
                'latitud' => $otherUser->latitud,
                'longitud' => $otherUser->longitud,
                'biografia' => $otherUser->biografia,
                'foto_perfil_url' => $otherUser->foto_perfil_url,
                'puntuacion_general' => $compat->puntuacion_general,
                'descripcion_breve' => $compat->descripcion_breve,
                'analisis_detallado' => $compat->analisis_detallado,
                'distancia_km' => round($distance), // Redondear la distancia
                'signos' => [
                    'solar' => $solarSign ? [
                        'nombre_signo' => $solarSign->nombre_signo,
                        'elemento' => $solarSign->elemento,
                        'modalidad' => $solarSign->modalidad,
                    ] : null,
                    'lunar' => $lunarSign ? [
                        'nombre_signo' => $lunarSign->nombre_signo,
                        'elemento' => $lunarSign->elemento,
                        'modalidad' => $lunarSign->modalidad,
                    ] : null,
                    'ascendente' => $ascendantSign ? [
                        'nombre_signo' => $ascendantSign->nombre_signo,
                        'elemento' => $ascendantSign->elemento,
                        'modalidad' => $ascendantSign->modalidad,
                    ] : null,
                ],
                'imagenes_perfil' => $additionalImages, // Incluir las imágenes adicionales
            ]);
        }

        // Ordenar los matches: primero por distancia (más cercanos) y luego por puntuación de compatibilidad (más alta)
        $sortedMatches = $potentialMatches->sortBy(function ($match) {
            return [$match['distancia_km'], - $match['puntuacion_general']];
        })->values()->all(); // Reset keys after sorting

        return response()->json(['matches' => $sortedMatches]);
    }

    /**
     * Procesa una interacción de perfil (like/dislike).
     *
     * @param int $targetUserId El ID del usuario con el que se interactúa.
     * @param string $interactionType El tipo de interacción ('like' o 'dislike').
     * @return \Illuminate\Http\JsonResponse
     */
    public function processInteraction(int $targetUserId, string $interactionType)
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

        try {
            // Crear o actualizar la interacción
            InteraccionPerfil::updateOrCreate(
                [
                    'id_emisor' => $currentUser->id,
                    'id_receptor' => $targetUserId,
                ],
                [
                    'tipo_interaccion' => $interactionType,
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

        } catch (\Exception $e) {
            Log::error("Error en processInteraction: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la interacción'
            ], 500);
        }
    }

    /**
     * Muestra la vista del perfil de un usuario con el que se hizo match.
     * Esto es solo un placeholder, la lógica real para mostrar el perfil completo iría aquí.
     *
     * @param int $userId
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function showMatchedProfile($userId)
    {
        $user = AstrologicalUser::with([
            'datosAstralesBasicos.signoSolar',
            'groqAstrologyData.signoLunar',
            'groqAstrologyData.signoAscendente',
            'imagenesPerfil'
        ])->find($userId);

        if (!$user) {
            return redirect()->route('dashboard')->with('error', 'Perfil no encontrado.');
        }

        return view('others.matched_profile', compact('user'));
    }

    /**
     * Obtiene y devuelve la lista de usuarios con los que el usuario actual ha hecho match.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getActiveMatches(Request $request)
    {
        $currentUser = Auth::user();

        if (!$currentUser) {
            return response()->json(['error' => 'Usuario no autenticado.'], 401);
        }

        // Obtener todos los emparejamientos activos donde el usuario actual es usuario1_id o usuario2_id
        $activeMatches = Emparejamientos::where(function ($query) use ($currentUser) {
                                            $query->where('usuario1_id', $currentUser->id)
                                                  ->orWhere('usuario2_id', $currentUser->id);
                                        })
                                        ->where('estado', 'activo')
                                        ->get();

        $matchedUsersData = [];
        foreach ($activeMatches as $match) {
            $otherUserId = ($match->usuario1_id === $currentUser->id) ? $match->usuario2_id : $match->usuario1_id;
            $otherUser = AstrologicalUser::find($otherUserId);

            if ($otherUser) {
                $matchedUsersData[] = [
                    'id' => $otherUser->id,
                    'nombre_completo' => $otherUser->nombre_completo,
                    'foto_perfil_url' => $otherUser->foto_perfil_url,
                    'last_message' => $this->getLastMessage($currentUser->id, $otherUser->id), // Obtener el último mensaje
                    'unread_messages' => $this->getUnreadMessageCount($currentUser->id, $otherUser->id), // Contar mensajes no leídos
                    'fecha_emparejamiento' => $match->fecha_emparejamiento,
                ];
            }
        }

        // Opcional: Ordenar los matches por el último mensaje o fecha de emparejamiento
        // Por ejemplo, por fecha del último mensaje (más reciente primero) o por fecha de emparejamiento.
        usort($matchedUsersData, function($a, $b) {
            $dateA = $a['last_message']['fecha_envio'] ?? $a['fecha_emparejamiento'];
            $dateB = $b['last_message']['fecha_envio'] ?? $b['fecha_emparejamiento'];
            return strtotime($dateB) - strtotime($dateA);
        });


        return response()->json(['matches' => $matchedUsersData]);
    }

    /**
     * Obtiene los mensajes entre dos usuarios.
     *
     * @param Request $request
     * @param int $targetUserId El ID del otro usuario en la conversación.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMessages(Request $request, int $targetUserId)
    {
        $currentUser = Auth::user();

        if (!$currentUser) {
            return response()->json(['error' => 'Usuario no autenticado.'], 401);
        }

        // Verificar que exista un match activo entre los dos usuarios
        $matchExists = Emparejamientos::where('estado', 'activo')
                                    ->where(function($query) use ($currentUser, $targetUserId) {
                                        $query->where(function($q) use ($currentUser, $targetUserId) {
                                            $q->where('usuario1_id', $currentUser->id)
                                              ->where('usuario2_id', $targetUserId);
                                        })->orWhere(function($q) use ($currentUser, $targetUserId) {
                                            $q->where('usuario1_id', $targetUserId)
                                              ->where('usuario2_id', $currentUser->id);
                                        });
                                    })
                                    ->exists();

        if (!$matchExists) {
            return response()->json(['error' => 'No hay un match activo con este usuario.'], 403);
        }

        // Obtener mensajes entre los dos usuarios, ordenados por fecha de envío
        $messages = Mensaje::where(function ($query) use ($currentUser, $targetUserId) {
                                $query->where('id_remitente', $currentUser->id)
                                      ->where('id_receptor', $targetUserId);
                            })
                            ->orWhere(function ($query) use ($currentUser, $targetUserId) {
                                $query->where('id_remitente', $targetUserId)
                                      ->where('id_receptor', $currentUser->id);
                            })
                            ->orderBy('fecha_envio', 'asc')
                            ->get();

        // Marcar mensajes como leídos si el receptor es el usuario actual
        Mensaje::where('id_receptor', $currentUser->id)
               ->where('id_remitente', $targetUserId)
               ->where('leido', false)
               ->update(['leido' => true]);

        return response()->json(['messages' => $messages]);
    }

    /**
     * Envía un nuevo mensaje.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendMessage(Request $request)
    {
        $currentUser = Auth::user();

        if (!$currentUser) {
            return response()->json(['message' => 'Usuario no autenticado.'], 401);
        }

        $validatedData = $request->validate([
            'id_receptor' => 'required|exists:astrological_users,id',
            'contenido' => 'required|string|max:1000',
        ]);

        $idReceptor = $validatedData['id_receptor'];
        $contenido = $validatedData['contenido'];

        // Verificar que exista un match activo entre los dos usuarios antes de permitir el envío del mensaje
        $matchExists = Emparejamientos::where('estado', 'activo')
                                    ->where(function($query) use ($currentUser, $idReceptor) {
                                        $query->where(function($q) use ($currentUser, $idReceptor) {
                                            $q->where('usuario1_id', $currentUser->id)
                                              ->where('usuario2_id', $idReceptor);
                                        })->orWhere(function($q) use ($currentUser, $idReceptor) {
                                            $q->where('usuario1_id', $idReceptor)
                                              ->where('usuario2_id', $currentUser->id);
                                        });
                                    })
                                    ->exists();

        if (!$matchExists) {
            return response()->json(['error' => 'No tienes un match activo con este usuario para enviar mensajes.'], 403);
        }

        $message = Mensaje::create([
            'id_remitente' => $currentUser->id,
            'id_receptor' => $idReceptor,
            'contenido' => $contenido,
            'fecha_envio' => now(),
            'leido' => false,
        ]);

        return response()->json(['message' => 'Mensaje enviado', 'data' => $message], 201);
    }


    /**
     * Helper: Obtiene el último mensaje entre dos usuarios.
     * @param int $userId1
     * @param int $userId2
     * @return array|null
     */
    protected function getLastMessage(int $userId1, int $userId2): ?array
    {
        $message = Mensaje::where(function ($query) use ($userId1, $userId2) {
                                $query->where('id_remitente', $userId1)
                                      ->where('id_receptor', $userId2);
                            })
                            ->orWhere(function ($query) use ($userId1, $userId2) {
                                $query->where('id_remitente', $userId2)
                                      ->where('id_receptor', $userId1);
                            })
                            ->orderBy('fecha_envio', 'desc')
                            ->first();

        return $message ? $message->toArray() : null;
    }

    /**
     * Helper: Cuenta los mensajes no leídos para el usuario actual de un remitente específico.
     * @param int $currentUserId
     * @param int $senderId
     * @return int
     */
    protected function getUnreadMessageCount(int $currentUserId, int $senderId): int
    {
        return Mensaje::where('id_receptor', $currentUserId)
                      ->where('id_remitente', $senderId)
                      ->where('leido', false)
                      ->count();
    }

    /**
     * Obtiene las opciones disponibles para los filtros de búsqueda.
     * Incluye géneros, orientaciones sexuales y tags categorizados.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getFilterOptions()
    {
        // Obtener géneros y orientaciones sexuales directamente del modelo o definirlos
        // Si estos valores son fijos, es mejor definirlos como constantes o en un archivo de configuración.
        // Asumiendo que están en el código de validación de AstrologicalUser:
        $generos = ['Masculino', 'Femenino'];
        $orientacionesSexuales = ['Heterosexual', 'Homosexual', 'Bisexual', 'Pansexual', 'Asexual'];

        // Obtener todos los tags maestros y agruparlos por categoría
        $tags = TagMaestro::orderBy('categoria')->orderBy('nombre_tag')->get()->groupBy('categoria');

        return response()->json([
            'generos' => $generos,
            'orientaciones_sexuales' => $orientacionesSexuales,
            'tags' => $tags,
        ]);
    }
}
