<?php

namespace App\Jobs;

use App\Models\AstrologicalUser;
use App\Models\UserDistance;
use App\Services\LocationService; // Importa el servicio
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log; // Para depuración

class CalculateUserDistances implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $currentUser;

    /**
     * Create a new job instance.
     *
     * @param AstrologicalUser $currentUser El usuario que inició sesión (usuario 1)
     * @return void
     */
    public function __construct(AstrologicalUser $currentUser)
    {
        $this->currentUser = $currentUser;
    }

    /**
     * Execute the job.
     *
     * @param LocationService $locationService Laravel inyectará automáticamente el servicio
     * @return void
     */
    public function handle(LocationService $locationService)
    {
        Log::info('Iniciando cálculo de distancias para el usuario: ' . $this->currentUser->id);

        // Obtener las coordenadas del usuario actual
        $lat1 = $this->currentUser->latitud;
        $lon1 = $this->currentUser->longitud;

        // Si el usuario actual no tiene latitud o longitud, no podemos calcular distancias
        if (is_null($lat1) || is_null($lon1)) {
            Log::warning('Usuario ' . $this->currentUser->id . ' no tiene coordenadas válidas. Saltando cálculo de distancias.');
            return;
        }

        // Obtener todos los demás usuarios, excluyendo al usuario actual
        // y que tengan coordenadas
        $otherUsers = AstrologicalUser::where('id', '!=', $this->currentUser->id)
                                      ->whereNotNull('latitud')
                                      ->whereNotNull('longitud')
                                      ->get();

        foreach ($otherUsers as $otherUser) {
            $lat2 = $otherUser->latitud;
            $lon2 = $otherUser->longitud;

            // Calcular la distancia usando el servicio
            $distance = $locationService->calculateDistance($lat1, $lon1, $lat2, $lon2);

            // Para asegurar la unicidad del par (A, B) sin importar el orden,
            // siempre guarda el ID más pequeño como id_usuario1
            $idA = min($this->currentUser->id, $otherUser->id);
            $idB = max($this->currentUser->id, $otherUser->id);

            // Busca o crea la entrada de distancia
            UserDistance::updateOrCreate(
                [
                    'id_usuario1' => $idA,
                    'id_usuario2' => $idB,
                ],
                [
                    'distancia_km' => $distance,
                    'fecha_calculo' => now(),
                ]
            );

            Log::debug("Distancia calculada entre " . $this->currentUser->id . " y " . $otherUser->id . ": " . $distance . " km");
        }

        Log::info('Cálculo de distancias completado para el usuario: ' . $this->currentUser->id);
    }

    /**
     * Handle a job failure.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(\Throwable $exception)
    {
        Log::error('El Job CalculateUserDistances falló para el usuario ' . $this->currentUser->id . ': ' . $exception->getMessage());
    }
}