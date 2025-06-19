<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenesPerfil extends Model
{
    use HasFactory;

    protected $table = 'imagenes_perfil';
    protected $primaryKey = 'id_imagen';
    public $timestamps = false; // Como tu migración indica 'fecha_subida' y no created_at/updated_at

    protected $fillable = [
        'id_usuario',
        'url_imagen',
        'orden',
        'fecha_subida',
    ];

    // Relación con AstrologicalUser
    public function user()
    {
        return $this->belongsTo(AstrologicalUser::class, 'id_usuario');
    }
}
