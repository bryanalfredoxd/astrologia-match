<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosAstralesBasicos extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_datos_astrales';

    protected $fillable = [
        'id_usuario',
        'id_signo_solar',
        'id_signo_lunar',
        'id_ascendente',
        'fecha_calculo',
    ];

    public function user()
    {
        return $this->belongsTo(AstrologicalUser::class, 'id_usuario');
    }

    public function signoSolar()
    {
        return $this->belongsTo(SignoZodiacal::class, 'id_signo_solar', 'id_signo');
    }

    public function signoLunar()
    {
        return $this->belongsTo(SignoZodiacal::class, 'id_signo_lunar', 'id_signo');
    }

    public function ascendente()
    {
        return $this->belongsTo(SignoZodiacal::class, 'id_ascendente', 'id_signo');
    }
}