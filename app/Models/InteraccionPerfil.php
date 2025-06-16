<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InteraccionPerfil extends Model
{
    use HasFactory;

    protected $table = 'interacciones_perfil';
    protected $primaryKey = 'id_interaccion';
    public $timestamps = false; // La migración tiene 'fecha_interaccion' pero no 'created_at'/'updated_at' estándar

    protected $fillable = [
        'id_emisor',
        'id_receptor',
        'tipo_interaccion',
        'fecha_interaccion',
    ];

    /**
     * Relación con el usuario que emite la interacción.
     */
    public function emisor()
    {
        return $this->belongsTo(AstrologicalUser::class, 'id_emisor');
    }

    /**
     * Relación con el usuario que recibe la interacción.
     */
    public function receptor()
    {
        return $this->belongsTo(AstrologicalUser::class, 'id_receptor');
    }
}