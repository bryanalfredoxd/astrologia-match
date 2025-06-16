<?php

namespace App\Jobs;

use App\Models\AstrologicalUser; // Asegúrate de que este modelo esté importado
use App\Models\UserDistance;
use App\Models\Compatibilidad;
use App\Jobs\CalculateAstrologicalCompatibility; // ¡Importa el nuevo Job!
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CalculateCompatibilityMatches implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $currentUser;
    protected $distanceThreshold = 50; // Distancia máxima en km para ser considerado un match

    /**
     * Create a new job instance.
     *
     * @param AstrologicalUser $currentUser El usuario para quien se calcularán los matches.
     * @return void
     */
    public function __construct(AstrologicalUser $currentUser)
    {
        $this->currentUser = $currentUser;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('Iniciando cálculo de compatibilidad por proximidad para el usuario: ' . $this->currentUser->id);

        try {
            // Obtener todas las distancias donde el usuario actual es id_usuario1 o id_usuario2
            // y la distancia es menor a 50km
            $nearbyUsersDistances = UserDistance::where(function ($query) {
                $query->where('id_usuario1', $this->currentUser->id)
                      ->orWhere('id_usuario2', $this->currentUser->id);
            })
            ->where('distancia_km', '<=', $this->distanceThreshold)
            ->get();

            Log::debug('Distancias cercanas encontradas para usuario ' . $this->currentUser->id . ': ' . $nearbyUsersDistances->count());

            foreach ($nearbyUsersDistances as $distanceEntry) {
                // Identificar al "otro usuario" en el par de distancia
                $otherUserId = ($distanceEntry->id_usuario1 === $this->currentUser->id)
                                ? $distanceEntry->id_usuario2
                                : $distanceEntry->id_usuario1;

                // Para asegurar que el par (usuario1_id, usuario2_id) sea único y consistente (ej. siempre el menor primero)
                $idA = min($this->currentUser->id, $otherUserId);
                $idB = max($this->currentUser->id, $otherUserId);

                // Evitar intentar hacer match consigo mismo
                if ($idA === $idB) {
                    continue;
                }

                // Verificar si ya existe un registro de compatibilidad para este par
                $existingCompatibility = Compatibilidad::where(function ($query) use ($idA, $idB) {
                    $query->where('id_usuario1', $idA)
                          ->where('id_usuario2', $idB);
                })->first();

                $compatibilidadToProcess = null; // Variable para almacenar el registro a procesar astrológicamente

                if (!$existingCompatibility) {
                    // Si no existe, crear el nuevo registro en la tabla de compatibilidad
                    $newCompatibility = Compatibilidad::create([
                        'id_usuario1' => $idA,
                        'id_usuario2' => $idB,
                        // Los campos 'puntuacion_general', 'descripcion_breve', 'analisis_detallado' se dejan NULL inicialmente
                        'fecha_calculo' => DB::raw('CURRENT_TIMESTAMP'), // Usar la función de base de datos para la fecha
                    ]);
                    Log::info('Match de compatibilidad por proximidad creado: U' . $idA . ' y U' . $idB);
                    $compatibilidadToProcess = $newCompatibility;
                } else {
                    Log::debug('Match de compatibilidad por proximidad ya existe para: U' . $idA . ' y U' . $idB);

                    // Si el match ya existe pero la puntuación astrológica no ha sido calculada, o quieres recalcularla
                    // Puedes ajustar esta condición si solo quieres calcularla una vez (ej. solo si es NULL)
                    if (is_null($existingCompatibility->puntuacion_general) || $existingCompatibility->puntuacion_general == 0) {
                        Log::info('Match existente pero sin puntuación astrológica, despachando cálculo: U' . $idA . ' y U' . $idB);
                        $compatibilidadToProcess = $existingCompatibility;
                    }
                }

                // Despachar el Job de CalculateAstrologicalCompatibility si hay un registro para procesar
                if ($compatibilidadToProcess) {
                    // Cargar los objetos AstrologicalUser completos para pasar al Job
                    $userA = AstrologicalUser::find($idA);
                    $userB = AstrologicalUser::find($idB);

                    if ($userA && $userB) {
                        CalculateAstrologicalCompatibility::dispatch($userA, $userB, $compatibilidadToProcess->id_compatibilidad);
                        Log::info('Job CalculateAstrologicalCompatibility despachado para match #' . $compatibilidadToProcess->id_compatibilidad);
                    } else {
                        Log::error("No se pudieron encontrar los objetos AstrologicalUser para U{$idA} y U{$idB} para el cálculo astrológico del match #{$compatibilidadToProcess->id_compatibilidad}.");
                    }
                }
            }

            Log::info('Cálculo de compatibilidad por proximidad completado para el usuario: ' . $this->currentUser->id);

        } catch (\Exception $e) {
            Log::error('El Job CalculateCompatibilityMatches falló para el usuario ' . $this->currentUser->id . ': ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e; // Re-lanza la excepción para que Laravel la maneje (ej. reintentos)
        }
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(\Throwable $exception)
    {
        Log::error('El Job CalculateCompatibilityMatches falló permanentemente para el usuario ' . $this->currentUser->id . ': ' . $exception->getMessage(), [
            'exception' => $exception,
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
