<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroqAstrologyData extends Model
{
    use HasFactory;

    protected $table = 'groq_astrology_data'; // Nombre de la tabla
    protected $fillable = [
        'user_id',
        'signo_lunar_id',
        'signo_ascendente_id',
    ];

    /**
     * Get the user that owns the GroqAstrologyData.
     */
    public function user()
    {
        return $this->belongsTo(AstrologicalUser::class, 'user_id');
    }

    /**
     * Get the lunar sign associated with the GroqAstrologyData.
     */
    public function signoLunar()
    {
        return $this->belongsTo(SignoZodiacal::class, 'signo_lunar_id', 'id_signo');
    }

    /**
     * Get the ascendent sign associated with the GroqAstrologyData.
     */
    public function signoAscendente()
    {
        return $this->belongsTo(SignoZodiacal::class, 'signo_ascendente_id', 'id_signo');
    }
}