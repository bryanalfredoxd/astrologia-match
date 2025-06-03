<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SignoZodiacal extends Model
{
    use HasFactory;

    protected $table = 'signos_zodiacales';
    protected $primaryKey = 'id_signo'; // Especificar la primary key si no es 'id'
    public $timestamps = false; // No usamos timestamps en esta tabla

    protected $fillable = [
        'nombre_signo',
        'elemento',
        'modalidad',
    ];
}