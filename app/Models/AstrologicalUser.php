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

    // NUEVA RELACIÓN: 1:N con ImagenesPerfil
    public function imagenesPerfil()
    {
        return $this->hasMany(ImagenesPerfil::class, 'id_usuario')->orderBy('orden');
    }

    // NUEVA RELACIÓN: 1:N con UsuarioTag
    public function usuarioTags()
    {
        return $this->hasMany(UsuarioTag::class, 'id_usuario');
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
        if ($this->datosAstralesBasicos) {
            $totalFields++; // Contamos id_signo_solar como un campo completo
            $completedCount++;
        } else {
             $totalFields++;
        }

        // Datos de GroqAstrologyData (signo lunar y ascendente)
        if ($this->groqAstrologyData) {
            $totalFields += 2; // Lunar y Ascendente
            if ($this->groqAstrologyData->signo_lunar_id !== 13 && !is_null($this->groqAstrologyData->signo_lunar_id)) {
                $completedCount++;
            }
            if ($this->groqAstrologyData->signo_ascendente_id !== 13 && !is_null($this->groqAstrologyData->signo_ascendente_id)) {
                $completedCount++;
            }
        } else {
            $totalFields += 2;
        }

        // NUEVO: Imágenes de perfil adicionales
        // Consideramos que tener al menos una imagen adicional suma un punto, o más si se quiere por cada una.
        // Aquí vamos a contarlas como un campo de completitud si el usuario tiene al menos una imagen adicional.
        $totalFields++;
        if ($this->imagenesPerfil->count() > 0) {
            $completedCount++;
        }

        // NUEVO: Tags de perfil adicionales
        $totalFields++; // Consideramos los tags como un campo de completitud
        if ($this->usuarioTags->count() > 0) {
            $completedCount++;
        }

        if ($totalFields === 0) {
            return 0;
        }

        return (int) round(($completedCount / $totalFields) * 100);
    }
}