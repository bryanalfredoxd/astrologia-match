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

    // Relación 1:1 con GroqAstrologyData
    public function groqAstrologyData()
    {
        return $this->hasOne(GroqAstrologyData::class, 'user_id');
    }

    /**
     * Calcula el porcentaje de completitud del perfil.
     * @return int
     */
    public function getProfileCompletionPercentageAttribute()
    {
        $completedCount = 0;
        $totalFields = 0;

        // Campos obligatorios/esperados de astrological_users
        $userFields = [
            'nombre_completo', 'email', 'fecha_nacimiento', 'hora_nacimiento',
            'lugar_nacimiento', 'genero', 'orientacion_sexual'
        ];

        foreach ($userFields as $field) {
            $totalFields++;
            if (!empty($this->$field)) {
                $completedCount++;
            }
        }

        // Campos opcionales de astrological_users que suman al porcentaje
        $optionalUserFields = [
            'biografia', 'foto_perfil_url'
        ];

        foreach ($optionalUserFields as $field) {
            $totalFields++;
            if (!empty($this->$field)) {
                $completedCount++;
            }
        }

        // Geolocalización: considera latitud y longitud como un solo punto de completitud
        $totalFields++; // Contamos 1 campo para latitud/longitud
        if (!is_null($this->latitud) && !is_null($this->longitud)) {
            $completedCount++;
        }

        // Datos Astrales Básicos
        // Asume que id_signo_solar siempre se llena al registrar.
        // Si existiera la posibilidad de que DatosAstralesBasicos no se creara,
        // o que id_signo_solar pudiera ser un "placeholder" con ID 13,
        // necesitaríamos añadir un check para su existencia/validez.
        // Dado que se crea en el controlador, la existencia del registro ya indica un progreso.
        if ($this->datosAstralesBasicos) {
            $totalFields++; // Contamos id_signo_solar como un campo completo
            $completedCount++; // Asumimos que si existe el registro, el signo solar está asignado.
        } else {
             // Si datosAstralesBasicos no existe, el signo solar no está completo.
             $totalFields++; // Aún así lo contamos como un campo esperado.
        }


        // Datos de GroqAstrologyData (signo lunar y ascendente)
        if ($this->groqAstrologyData) {
            $totalFields += 2; // Lunar y Ascendente
            // Si el signo lunar no es el "Nada" (ID 13), se considera completo
            if ($this->groqAstrologyData->signo_lunar_id !== 13 && !is_null($this->groqAstrologyData->signo_lunar_id)) {
                $completedCount++;
            }
            // Si el signo ascendente no es el "Nada" (ID 13), se considera completo
            if ($this->groqAstrologyData->signo_ascendente_id !== 13 && !is_null($this->groqAstrologyData->signo_ascendente_id)) {
                $completedCount++;
            }
        } else {
            $totalFields += 2; // Si no existe el registro, se consideran campos esperados
        }


        if ($totalFields === 0) {
            return 0;
        }

        return (int) round(($completedCount / $totalFields) * 100);
    }
}