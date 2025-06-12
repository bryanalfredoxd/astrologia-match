<?php

namespace App\Services;

class LocationService
{
    /**
     * Radio de la Tierra en kilómetros.
     * @var int
     */
    const EARTH_RADIUS_KM = 6371;

    /**
     * Calcula la distancia entre dos puntos en la Tierra usando la fórmula del Haversine.
     *
     * @param float $lat1 Latitud del punto 1
     * @param float $lon1 Longitud del punto 1
     * @param float $lat2 Latitud del punto 2
     * @param float $lon2 Longitud del punto 2
     * @return float Distancia en kilómetros
     */
    public function calculateDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $lat1 = deg2rad($lat1);
        $lat2 = deg2rad($lat2);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos($lat1) * cos($lat2) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        $distance = self::EARTH_RADIUS_KM * $c; // Distancia en kilómetros

        return round($distance, 2); // Redondea a 2 decimales
    }
}