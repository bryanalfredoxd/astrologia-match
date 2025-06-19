<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagMaestro extends Model
{
    use HasFactory;

    protected $table = 'tags_maestros';
    protected $primaryKey = 'id_tag';
    public $timestamps = false; // This table does not have created_at/updated_at

    protected $fillable = [
        'nombre_tag',
        'categoria',
    ];

    // Optional: If you want to get users associated with this tag
    public function usuarios()
    {
        return $this->belongsToMany(AstrologicalUser::class, 'usuario_tags', 'id_tag', 'id_usuario');
    }
}