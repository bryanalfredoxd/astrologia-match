<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosAstralesBasicos extends Model
{
    use HasFactory;

    protected $table = 'datos_astrales_basicos';
    protected $primaryKey = 'id_datos_astrales'; // Si no es 'id' por defecto

    // ¡Añade esta línea!
    public $timestamps = false; // Indica a Eloquent que no use created_at y updated_at

    protected $fillable = [
        'id_usuario',
        'id_signo_solar',
        'fecha_calculo',
    ];

    // Relación con AstrologicalUser
    public function astrologicalUser()
    {
        return $this->belongsTo(AstrologicalUser::class, 'id_usuario');
    }

    // Relación con SignoZodiacal
    public function signoSolar()
    {
        return $this->belongsTo(SignoZodiacal::class, 'id_signo_solar');
    }
}