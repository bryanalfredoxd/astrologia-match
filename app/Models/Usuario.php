<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';

    protected $fillable = [
        'nombre', 'apellido', 'email', 'contrasena', 'fecha_nacimiento', 'genero',
        'signo_solar', 'signo_lunar', 'signo_ascendente', 'foto_perfil', 'descripcion',
        'ip_registro', 'pais', 'ciudad', 'latitud', 'longitud', 'ubicacion_manual',
        'trabaja', 'puesto_trabajo', 'empresa', 'estudia', 'institucion', 'motivo',
        'altura', 'hijos', 'bebe', 'fuma', 'idiomas', 'mascotas', 'relacion_actual',
        'sexualidad', 'religion', 'personalidad', 'nivel_educativo', 'tipo_relacion',
        'aceptar_hijos', 'dispuesto_mudarse', 'citas_virtuales', 'tipo_cuerpo',
        'alimentacion', 'actividad_fisica', 'valores', 'ingresos', 'compartir_gastos',
        'musica_favorita', 'entretenimiento', 'estilo_comunicacion', 'estado_cuenta'
    ];

    public $timestamps = false;
}
