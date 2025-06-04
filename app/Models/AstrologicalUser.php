<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AstrologicalUser extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'astrological_users'; // Nombre de la tabla

    protected $fillable = [
        'nombre_completo',
        'email',
        'password',
        'fecha_nacimiento',
        'hora_nacimiento',
        'lugar_nacimiento',
        'genero',
        'orientacion_sexual',
        'latitud',
        'longitud',
        'biografia',
        'foto_perfil_url',
        'activo',
        'email_verificado_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verificado_at' => 'datetime',
        'fecha_nacimiento' => 'date',
        'hora_nacimiento' => 'datetime',
    ];

    // Relación 1:1 con DatosAstralesBasicos
    public function datosAstralesBasicos()
    {
        return $this->hasOne(DatosAstralesBasicos::class, 'id_usuario');
    }

    /**
     * Calcula el porcentaje de completitud del perfil.
     * @return int
     */
    public function getProfileCompletionPercentageAttribute()
    {
        $totalFields = 10; // Campos obligatorios que esperas rellenar
        $completedFields = 0;

        // 1. Campos de astrological_users que no deben ser nulos/vacíos
        $requiredUserFields = [
            'nombre_completo',
            'email',
            'fecha_nacimiento',
            'hora_nacimiento',
            'lugar_nacimiento',
            'genero',
            'orientacion_sexual',
        ];

        foreach ($requiredUserFields as $field) {
            if (!empty($this->$field)) {
                $completedFields++;
            }
        }

        // Campos adicionales (opcionales pero suman si están presentes)
        if (!empty($this->biografia)) {
            $completedFields++;
        }
        if (!empty($this->foto_perfil_url)) {
            $completedFields++;
        }
        // Puedes ajustar el peso de latitud/longitud si son obligatorios para ti
        if (!is_null($this->latitud) && !is_null($this->longitud)) {
             $completedFields++;
        }


        // 2. Campos de datos_astrales_basicos (si la relación existe)
        if ($this->datosAstralesBasicos) {
            // id_signo_lunar no debe ser 13
            if ($this->datosAstralesBasicos->id_signo_lunar !== 13) {
                $completedFields++;
            }
            // id_ascendente no debe ser 13
            if ($this->datosAstralesBasicos->id_ascendente !== 13) {
                $completedFields++;
            }
            // También podemos considerar si el signo solar ya está calculado (no es placeholder)
            // Asumiendo que id_signo_solar nunca será 13 o nulo si se calculó.
            // Si el signo solar ya está asignado al momento de crear DatosAstralesBasicos, ya suma.
            // No lo añadimos aquí para no duplicar si ya se cuenta por la existencia del registro.
        } else {
             // Si no hay datos astrales basicos, la barra de progreso no sera completa
             // Esto significa que id_signo_lunar y id_ascendente no se han llenado
             $totalFields += 2; // Añadimos estos dos campos al total esperado
        }


        // Calcular el porcentaje
        // Asegúrate de que $totalFields sea al menos 1 para evitar división por cero
        $totalPossibleFields = count($requiredUserFields) + 3; // 7 de user + biografia + foto + lat/lon
        if ($this->datosAstralesBasicos) {
            $totalPossibleFields += 2; // + signo lunar y ascendente
        } else {
            // Si el registro de datos astrales no existe, esos 2 campos no pueden estar "completos"
            // Por lo tanto, el total de campos posibles para la división debe ser menor,
            // o debemos considerar que esos 2 campos aún no se pueden completar.
            // Para simplificar, asumimos que si el registro existe, esperamos 2 campos.
            // Si no existe, no los contamos en el total de campos completados, pero sí en el total base si se esperan.
        }

        // Una forma más robusta de contar:
        $totalCountableFields = [
            'nombre_completo', 'email', 'fecha_nacimiento', 'hora_nacimiento',
            'lugar_nacimiento', 'genero', 'orientacion_sexual',
            'biografia', 'foto_perfil_url', 'latitud', 'longitud' // 11 campos de AstrologicalUser
        ];

        $completedCount = 0;

        foreach ($totalCountableFields as $field) {
            if (!empty($this->$field) || (!is_null($this->latitud) && !is_null($this->longitud) && ($field == 'latitud' || $field == 'longitud'))) {
                // Special handling for lat/lon as they are nullable decimals
                if ($field == 'latitud' || $field == 'longitud') {
                    // We check if both are not null as a single "completion" point for geo-location
                    // To avoid double counting, this specific check is outside the loop or handled carefully.
                    // For now, let's treat them individually, but be aware.
                    // A better approach might be:
                    // if (!is_null($this->latitud) && !is_null($this->longitud)) { $completedCount++; }
                    // and then skip latitud and longitud from the loop.
                    // For simplicity, let's just check for non-null/empty.
                    if ($this->$field !== null) { // Checks for non-null for decimal fields
                        $completedCount++;
                    }
                } else {
                    if (!empty($this->$field)) {
                        $completedCount++;
                    }
                }
            }
        }

        // Add 2 more fields if datosAstralesBasicos exists and specific IDs are not 13
        $expectedAstralFields = 0; // Initialize to 0, increment only if applicable
        if ($this->datosAstralesBasicos) {
            $expectedAstralFields = 2; // We expect signo lunar and ascendente
            if ($this->datosAstralesBasicos->id_signo_lunar !== 13) {
                $completedCount++;
            }
            if ($this->datosAstralesBasicos->id_ascendente !== 13) {
                $completedCount++;
            }
        }

        // Total fields to consider for percentage calculation
        $totalFieldsForPercentage = count($totalCountableFields) + $expectedAstralFields;

        if ($totalFieldsForPercentage === 0) {
            return 0;
        }

        return (int) round(($completedCount / $totalFieldsForPercentage) * 100);
    }
}