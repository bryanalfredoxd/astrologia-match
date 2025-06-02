<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AstrologicalUser extends Model
{
    use HasFactory;

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
    ];
}