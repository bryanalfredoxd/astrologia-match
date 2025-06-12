<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDistance extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_distancia';
    protected $fillable = [
        'id_usuario1',
        'id_usuario2',
        'distancia_km',
        'fecha_calculo',
    ];

    /**
     * Define la relación con el primer usuario.
     */
    public function user1()
    {
        return $this->belongsTo(AstrologicalUser::class, 'id_usuario1');
    }

    /**
     * Define la relación con el segundo usuario.
     */
    public function user2()
    {
        return $this->belongsTo(AstrologicalUser::class, 'id_usuario2');
    }
}