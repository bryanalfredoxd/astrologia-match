<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosAstralesBasicos extends Model
{
    use HasFactory;

    protected $table = 'datos_astrales_basicos';
    protected $primaryKey = 'id_datos_astrales';
    public $timestamps = false; // No usamos timestamps en esta tabla según tu migración

    protected $fillable = [
        'id_usuario',
        'id_signo_solar',
        'id_signo_lunar',
        'id_ascendente',
        'fecha_calculo',
    ];

    // Relación con AstrologicalUser
    public function usuario()
    {
        return $this->belongsTo(AstrologicalUser::class, 'id_usuario');
    }

    // Relación con SignoZodiacal para el signo solar
    public function signoSolar()
    {
        return $this->belongsTo(SignoZodiacal::class, 'id_signo_solar', 'id_signo');
    }

    // Puedes añadir relaciones para lunar y ascendente cuando los implementes
    public function signoLunar()
    {
        return $this->belongsTo(SignoZodiacal::class, 'id_signo_lunar', 'id_signo');
    }

    public function ascendente()
    {
        return $this->belongsTo(SignoZodiacal::class, 'id_ascendente', 'id_signo');
    }
}