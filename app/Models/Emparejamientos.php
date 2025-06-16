<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emparejamientos extends Model
{
    use HasFactory;

    protected $table = 'emparejamientos';
    protected $primaryKey = 'id_emparejamiento';
    // La migración tiene timestamps, así que los dejamos habilitados por defecto.
    // Si la migración sólo usa `fecha_emparejamiento` y no `created_at`/`updated_at`,
    // podrías añadir `public $timestamps = false;`

    protected $fillable = [
        'usuario1_id',
        'usuario2_id',
        'estado',
        'fecha_emparejamiento',
    ];

    /**
     * Relación con el primer usuario en el emparejamiento.
     */
    public function usuario1()
    {
        return $this->belongsTo(AstrologicalUser::class, 'usuario1_id');
    }

    /**
     * Relación con el segundo usuario en el emparejamiento.
     */
    public function usuario2()
    {
        return $this->belongsTo(AstrologicalUser::class, 'usuario2_id');
    }
}