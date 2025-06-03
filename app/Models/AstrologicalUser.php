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
}