<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    use HasFactory;

    protected $table = 'mensajes';
    protected $primaryKey = 'id_mensaje';

    // Si tu migración NO tiene `created_at` y `updated_at` y solo usa `fecha_envio`,
    // entonces añade: `public $timestamps = false;`
    // Tu migración `2025_06_03_134357_create_mensajes_table.php` SÍ tiene timestamps,
    // así que no necesitas `public $timestamps = false;` a menos que quieras deshabilitarlos.
    // Para Laravel, el `fecha_envio` DEFAULT current_timestamp() es diferente de los `timestamps()`.

    protected $fillable = [
        'id_remitente',
        'id_receptor',
        'contenido',
        'fecha_envio', // Si lo manejas manualmente
        'leido',
    ];

    protected $casts = [
        'fecha_envio' => 'datetime',
        'leido' => 'boolean',
    ];

    /**
     * Relación con el usuario remitente.
     */
    public function remitente()
    {
        return $this->belongsTo(AstrologicalUser::class, 'id_remitente');
    }

    /**
     * Relación con el usuario receptor.
     */
    public function receptor()
    {
        return $this->belongsTo(AstrologicalUser::class, 'id_receptor');
    }
}