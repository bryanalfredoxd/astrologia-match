<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AstrologicalUser extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'astrological_users';

    protected $fillable = [
        'nombre_completo',
        'email',
        'password',
        'fecha_nacimiento',
        'hora_nacimiento',
        'lugar_nacimiento',
        'genero',
        'orientacion_sexual'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}