<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compatibilidad extends Model
{
    use HasFactory;

    protected $table = 'compatibilidad'; // Nombre de la tabla
    protected $primaryKey = 'id_compatibilidad'; // Clave primaria

    protected $fillable = [
        'id_usuario1',
        'id_usuario2',
        'puntuacion_general',
        'descripcion_breve',
        'analisis_detallado',
        'fecha_calculo',
    ];

    public $timestamps = false; // Como manejas 'fecha_calculo' manualmente, puedes deshabilitar timestamps si no usas 'created_at'/'updated_at'

    /**
     * Define la relación con el primer usuario.
     */
    public function usuario1()
    {
        return $this->belongsTo(AstrologicalUser::class, 'id_usuario1');
    }

    /**
     * Define la relación con el segundo usuario.
     */
    public function usuario2()
    {
        return $this->belongsTo(AstrologicalUser::class, 'id_usuario2');
    }
}