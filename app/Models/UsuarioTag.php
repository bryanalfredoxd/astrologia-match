<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioTag extends Model
{
    use HasFactory;

    protected $table = 'usuario_tags';
    protected $primaryKey = 'id_usuario_tag';

    protected $fillable = [
        'id_usuario',
        'id_tag',
    ];

    protected $casts = [
        'fecha_asignacion' => 'datetime',
    ];

    // Define relationship to TagMaestro
    public function tagMaestro()
    {
        return $this->belongsTo(TagMaestro::class, 'id_tag', 'id_tag');
    }

    // Define relationship to AstrologicalUser
    public function user()
    {
        return $this->belongsTo(AstrologicalUser::class, 'id_usuario', 'id');
    }
}