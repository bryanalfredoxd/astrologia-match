<?php

namespace App\Jobs;

use App\Models\AstrologicalUser;
use App\Models\Compatibilidad;
use App\Models\SignoZodiacal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CalculateAstrologicalCompatibility implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user1;
    protected $user2;
    protected $compatibilidadId; // Para actualizar el registro existente

    /**
     * Create a new job instance.
     *
     * @param AstrologicalUser $user1
     * @param AstrologicalUser $user2
     * @param int $compatibilidadId El ID del registro de compatibilidad ya creado por proximidad.
     * @return void
     */
    public function __construct(AstrologicalUser $user1, AstrologicalUser $user2, int $compatibilidadId)
    {
        $this->user1 = $user1->load('datosAstralesBasicos.signoSolar', 'groqAstrologyData.signoLunar', 'groqAstrologyData.signoAscendente');
        $this->user2 = $user2->load('datosAstralesBasicos.signoSolar', 'groqAstrologyData.signoLunar', 'groqAstrologyData.signoAscendente');
        $this->compatibilidadId = $compatibilidadId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("Iniciando cálculo astrológico para compatibilidad #{$this->compatibilidadId} entre U{$this->user1->id} y U{$this->user2->id}");

        try {
            $puntuacionGeneral = 0;
            $motivosCompatibilidad = []; // Para construir la descripción breve
            $analisisDetallado = []; // Para el análisis detallado

            // Obtener datos astrológicos de ambos usuarios
            $solar1 = $this->user1->datosAstralesBasicos?->signoSolar;
            $lunar1 = $this->user1->groqAstrologyData?->signoLunar;
            $ascendente1 = $this->user1->groqAstrologyData?->signoAscendente;

            $solar2 = $this->user2->datosAstralesBasicos?->signoSolar;
            $lunar2 = $this->user2->groqAstrologyData?->signoLunar;
            $ascendente2 = $this->user2->groqAstrologyData?->signoAscendente;

            // Log de los signos recuperados (para depuración)
            Log::debug("U{$this->user1->id} - Solar: " . ($solar1->nombre_signo ?? 'N/A') . ", Lunar: " . ($lunar1->nombre_signo ?? 'N/A') . ", Ascendente: " . ($ascendente1->nombre_signo ?? 'N/A'));
            Log::debug("U{$this->user2->id} - Solar: " . ($solar2->nombre_signo ?? 'N/A') . ", Lunar: " . ($lunar2->nombre_signo ?? 'N/A') . ", Ascendente: " . ($ascendente2->nombre_signo ?? 'N/A'));


            // --- Criterio 1: Compatibilidad de Signos Solares (Peso: 30%) ---
            if ($solar1 && $solar2) {
                $puntuacionSolar = $this->calculateSignCompatibility($solar1, $solar2);
                $puntuacionGeneral += $puntuacionSolar * 0.30;
                $motivosCompatibilidad[] = "Signos Solares (" . $solar1->nombre_signo . " y " . $solar2->nombre_signo . ")";
                $analisisDetallado[] = "Compatibilidad Solar: " . $puntuacionSolar . " puntos. Representa la esencia y personalidad básica.";
            } else {
                Log::warning("Faltan datos de Signo Solar para U{$this->user1->id} o U{$this->user2->id}.");
            }

            // --- Criterio 2: Compatibilidad de Elementos (Peso: 25%) ---
            if ($solar1 && $solar2 && $solar1->elemento && $solar2->elemento) {
                $puntuacionElemento = $this->calculateElementCompatibility($solar1->elemento, $solar2->elemento);
                $puntuacionGeneral += $puntuacionElemento * 0.25;
                $motivosCompatibilidad[] = "Elementos (" . $solar1->elemento . " y " . $solar2->elemento . ")";
                $analisisDetallado[] = "Compatibilidad de Elementos: " . $puntuacionElemento . " puntos. Indica armonía en la forma de operar y energizar.";
            } else {
                Log::warning("Faltan datos de Elemento para U{$this->user1->id} o U{$this->user2->id}.");
            }

            // --- Criterio 3: Compatibilidad de Modalidades (Peso: 20%) ---
            if ($solar1 && $solar2 && $solar1->modalidad && $solar2->modalidad) {
                $puntuacionModalidad = $this->calculateModalityCompatibility($solar1->modalidad, $solar2->modalidad);
                $puntuacionGeneral += $puntuacionModalidad * 0.20;
                $motivosCompatibilidad[] = "Modalidades (" . $solar1->modalidad . " y " . $solar2->modalidad . ")";
                $analisisDetallado[] = "Compatibilidad de Modalidades: " . $puntuacionModalidad . " puntos. Determina cómo interactúan y abordan la vida.";
            } else {
                Log::warning("Faltan datos de Modalidad para U{$this->user1->id} o U{$this->user2->id}.");
            }

            // --- Criterio 4: Compatibilidad de Signos Lunares (Peso: 15%) ---
            if ($lunar1 && $lunar2 && $lunar1->id_signo !== 13 && $lunar2->id_signo !== 13) { // ID 13 es 'Nada'
                $puntuacionLunar = $this->calculateSignCompatibility($lunar1, $lunar2);
                $puntuacionGeneral += $puntuacionLunar * 0.15;
                $motivosCompatibilidad[] = "Signos Lunares (" . $lunar1->nombre_signo . " y " . $lunar2->nombre_signo . ")";
                $analisisDetallado[] = "Compatibilidad Lunar: " . $puntuacionLunar . " puntos. Crucial para la conexión emocional y la vida hogareña.";
            } else {
                Log::info("Faltan datos de Signo Lunar para U{$this->user1->id} o U{$this->user2->id}, o son 'Nada'. Se omitió el cálculo.");
            }

            // --- Criterio 5: Compatibilidad de Signos Ascendentes (Peso: 10%) ---
            if ($ascendente1 && $ascendente2 && $ascendente1->id_signo !== 13 && $ascendente2->id_signo !== 13) { // ID 13 es 'Nada'
                $puntuacionAscendente = $this->calculateSignCompatibility($ascendente1, $ascendente2);
                $puntuacionGeneral += $puntuacionAscendente * 0.10;
                $motivosCompatibilidad[] = "Signos Ascendentes (" . $ascendente1->nombre_signo . " y " . $ascendente2->nombre_signo . ")";
                $analisisDetallado[] = "Compatibilidad Ascendente: " . $puntuacionAscendente . " puntos. Influye en la primera impresión y la dinámica social.";
            } else {
                Log::info("Faltan datos de Signo Ascendente para U{$this->user1->id} o U{$this->user2->id}, o son 'Nada'. Se omitió el cálculo.");
            }

            // Asegurarse de que la puntuación esté entre 0 y 100
            $puntuacionFinal = round(min(100, max(0, $puntuacionGeneral)), 2);

            $descripcionBreve = $this->generateBreveDescription($puntuacionFinal, $motivosCompatibilidad);
            $analisisCompleto = $this->generateDetailedAnalysis($puntuacionFinal, $analisisDetallado, $solar1, $solar2);

            // Actualizar el registro de compatibilidad
            $compatibilidad = Compatibilidad::find($this->compatibilidadId);
            if ($compatibilidad) {
                $compatibilidad->puntuacion_general = $puntuacionFinal;
                $compatibilidad->descripcion_breve = $descripcionBreve;
                $compatibilidad->analisis_detallado = $analisisCompleto;
                $compatibilidad->fecha_calculo = DB::raw('CURRENT_TIMESTAMP'); // Actualizar la fecha de cálculo
                $compatibilidad->save();
                Log::info("Compatibilidad #{$this->compatibilidadId} actualizada con puntuación: {$puntuacionFinal}");
            } else {
                Log::error("No se encontró el registro de compatibilidad con ID: {$this->compatibilidadId}");
            }

        } catch (\Exception $e) {
            Log::error('El Job CalculateAstrologicalCompatibility falló para la compatibilidad # ' . $this->compatibilidadId . ': ' . $e->getMessage());
            // Opcional: Marcar la compatibilidad como "fallida" o reintentar
            throw $e; // Re-lanza la excepción para que Laravel la maneje si hay reintentos configurados
        }
    }

    /**
     * Calcula la compatibilidad entre dos signos astrológicos específicos (Solar, Lunar, Ascendente).
     * Esta es una lógica simplificada, puedes expandirla.
     * Basado en aspectos armónicos y tensos.
     *
     * @param SignoZodiacal $signo1
     * @param SignoZodiacal $signo2
     * @return float Puntuación de 0 a 100
     */
    protected function calculateSignCompatibility(SignoZodiacal $signo1, SignoZodiacal $signo2): float
    {
        $score = 0;

        // Misma posición zodiacal (muy raro pero muy fuerte)
        if ($signo1->id_signo === $signo2->id_signo) {
            $score += 90; // Súper armónico, se entienden profundamente
        }

        // Elementos y Modalidades
        $score += $this->calculateElementCompatibility($signo1->elemento, $signo2->elemento) * 0.4; // Pondera la afinidad de elemento
        $score += $this->calculateModalityCompatibility($signo1->modalidad, $signo2->modalidad) * 0.3; // Pondera la afinidad de modalidad

        // Compatibilidad por signos Opuestos (180 grados, por ejemplo, Aries-Libra) - muy atractivos pero desafiantes
        $opuestos = [
            1 => 7, 2 => 8, 3 => 9, 4 => 10, 5 => 11, 6 => 12,
            7 => 1, 8 => 2, 9 => 3, 10 => 4, 11 => 5, 12 => 6
        ];
        if (isset($opuestos[$signo1->id_signo]) && $opuestos[$signo1->id_signo] === $signo2->id_signo) {
            $score += 70; // Alta atracción, complementariedad, pero también tensión.
        }

        // Compatibilidad por Trinos (120 grados, mismo elemento, ej. Aries-Leo-Sagitario) - muy armónicos
        $trinos = [
            1 => [5, 9], 2 => [6, 10], 3 => [7, 11], 4 => [8, 12],
            5 => [1, 9], 6 => [2, 10], 7 => [3, 11], 8 => [4, 12],
            9 => [1, 5], 10 => [2, 6], 11 => [3, 7], 12 => [4, 8]
        ];
        if (isset($trinos[$signo1->id_signo]) && in_array($signo2->id_signo, $trinos[$signo1->id_signo])) {
            $score += 85; // Gran fluidez y comprensión mutua
        }

        // Compatibilidad por Sextiles (60 grados, elementos compatibles, ej. Aries-Géminis) - buena comunicación
        $sextiles = [
            1 => [3, 11], 2 => [4, 12], 3 => [1, 5], 4 => [2, 6],
            5 => [3, 7], 6 => [4, 8], 7 => [5, 9], 8 => [6, 10],
            9 => [7, 11], 10 => [8, 12], 11 => [1, 9], 12 => [2, 10]
        ];
        if (isset($sextiles[$signo1->id_signo]) && in_array($signo2->id_signo, $sextiles[$signo1->id_signo])) {
            $score += 65; // Buena comunicación y oportunidades
        }

        // Inarmónicos o desafiantes
        // Cuadraturas (90 grados, elementos incompatibles o mismos modalidades cardinal/fijo/mutable)
        $cuadraturas = [
            1 => [4, 10], 2 => [5, 11], 3 => [6, 12], 4 => [1, 7],
            5 => [2, 8], 6 => [3, 9], 7 => [4, 10], 8 => [5, 11],
            9 => [6, 12], 10 => [1, 7], 11 => [2, 8], 12 => [3, 9]
        ];
        if (isset($cuadraturas[$signo1->id_signo]) && in_array($signo2->id_signo, $cuadraturas[$signo1->id_signo])) {
            $score -= 30; // Tensión y fricción, pero también crecimiento
        }

        // Quincuncios (150 grados, elementos y modalidades incompatibles)
        $quincuncios = [
            1 => [6, 8], 2 => [7, 9], 3 => [8, 10], 4 => [9, 11],
            5 => [10, 12], 6 => [11, 1], 7 => [12, 2], 8 => [1, 3],
            9 => [2, 4], 10 => [3, 5], 11 => [4, 6], 12 => [5, 7]
        ];
        if (isset($quincuncios[$signo1->id_signo]) && in_array($signo2->id_signo, $quincuncios[$signo1->id_signo])) {
            $score -= 15; // Ajustes constantes, incomodidad
        }


        // Normalizar la puntuación a un rango de 0-100
        // Estos valores son arbitrarios y se pueden ajustar para que el rango final tenga sentido.
        // Un score base neutral de 50, con ajustes.
        $finalScore = max(0, min(100, 50 + $score));

        return round($finalScore, 2);
    }

    /**
     * Calcula la compatibilidad entre dos elementos astrológicos.
     *
     * @param string $elemento1
     * @param string $elemento2
     * @return float Puntuación de 0 a 100
     */
    protected function calculateElementCompatibility(string $elemento1, string $elemento2): float
    {
        // Fuego: Aries, Leo, Sagitario (Impulso, pasión)
        // Tierra: Tauro, Virgo, Capricornio (Estabilidad, practicidad)
        // Aire: Géminis, Libra, Acuario (Comunicación, intelecto)
        // Agua: Cáncer, Escorpio, Piscis (Emoción, intuición)

        // Elementos compatibles:
        // Fuego y Aire (se impulsan mutuamente) -> Muy alta
        // Tierra y Agua (se nutren mutuamente) -> Muy alta
        $compatible = [
            'Fuego' => ['Aire'],
            'Aire' => ['Fuego'],
            'Tierra' => ['Agua'],
            'Agua' => ['Tierra'],
        ];

        // Elementos neutrales/desafiantes (pueden funcionar con esfuerzo):
        // Fuego y Fuego (mucha pasión, a veces conflicto)
        // Tierra y Tierra (estables, a veces aburridos o tercos)
        // Aire y Aire (mucha charla, a veces falta de acción)
        // Agua y Agua (mucha emoción, a veces desborde)
        $sameElement = [
            'Fuego', 'Tierra', 'Aire', 'Agua'
        ];

        // Elementos incompatibles:
        // Fuego y Agua (uno extingue al otro)
        // Fuego y Tierra (uno quema al otro, o uno restringe al otro)
        // Aire y Agua (aire dispersa el agua, agua ahoga el aire)
        // Aire y Tierra (aire esparce la tierra, tierra frena el aire)
        $incompatible = [
            'Fuego' => ['Agua', 'Tierra'],
            'Agua' => ['Fuego', 'Aire'],
            'Tierra' => ['Fuego', 'Aire'],
            'Aire' => ['Agua', 'Tierra'],
        ];

        if ($elemento1 === $elemento2) {
            return 70; // Buena compatibilidad, se entienden
        } elseif (isset($compatible[$elemento1]) && in_array($elemento2, $compatible[$elemento1])) {
            return 90; // Muy alta compatibilidad, fluidez
        } elseif (isset($incompatible[$elemento1]) && in_array($elemento2, $incompatible[$elemento1])) {
            return 30; // Baja compatibilidad, grandes desafíos
        }

        return 50; // Neutro
    }

    /**
     * Calcula la compatibilidad entre dos modalidades astrológicas.
     *
     * @param string $modalidad1
     * @param string $modalidad2
     * @return float Puntuación de 0 a 100
     */
    protected function calculateModalityCompatibility(string $modalidad1, string $modalidad2): float
    {
        // Cardinal: Aries, Cáncer, Libra, Capricornio (Iniciadores, líderes)
        // Fijo: Tauro, Leo, Escorpio, Acuario (Estables, persistentes)
        // Mutable: Géminis, Virgo, Sagitario, Piscis (Adaptables, flexibles)

        // Misma modalidad:
        // Cardinal con Cardinal: Gran energía, pero choque de voluntades.
        // Fijo con Fijo: Muy estables, pero pueden ser inflexibles y tercos.
        // Mutable con Mutable: Adaptables, pero pueden carecer de dirección.
        if ($modalidad1 === $modalidad2) {
            return 60; // Entendimiento, pero posibles desafíos de la misma naturaleza
        }

        // Modalidades complementarias/fluidas (triplicidad de modalidades funciona)
        // Cardinal con Fijo (inicia, el otro mantiene) -> Muy buena
        // Fijo con Mutable (mantiene, el otro se adapta) -> Muy buena
        // Mutable con Cardinal (se adapta, el otro inicia) -> Muy buena
        $complementary = [
            'Cardinal' => ['Fijo', 'Mutable'], // Cardinal inicia y Fijo mantiene, Mutable se adapta a Cardinal
            'Fijo' => ['Cardinal', 'Mutable'], // Fijo mantiene lo que Cardinal inició, Mutable se adapta a Fijo
            'Mutable' => ['Fijo', 'Cardinal'], // Mutable se adapta a Fijo, Mutable se adapta a lo que Cardinal inicia
        ];

        if (isset($complementary[$modalidad1]) && in_array($modalidad2, $complementary[$modalidad1])) {
            return 80; // Buena complementariedad, trabajo en equipo
        }

        return 50; // Neutro o con posibles fricciones
    }


    /**
     * Genera una descripción breve basada en la puntuación.
     *
     * @param float $puntuacion
     * @param array $motivos
     * @return string
     */
    protected function generateBreveDescription(float $puntuacion, array $motivos): string
    {
        $motivosStr = '';
        if (!empty($motivos)) {
            $motivosStr = " Destacando en " . implode(", ", $motivos) . ".";
        }

        if ($puntuacion >= 85) {
            return "¡Una conexión estelar! Alta compatibilidad astrológica, prometiendo gran armonía y entendimiento mutuo." . $motivosStr;
        } elseif ($puntuacion >= 70) {
            return "Excelente compatibilidad. Tienen bases sólidas para una relación enriquecedora, con buen equilibrio en sus energías." . $motivosStr;
        } elseif ($puntuacion >= 50) {
            return "Buena compatibilidad. Existe un potencial de crecimiento mutuo, aunque podrían surgir algunos desafíos." . $motivosStr;
        } elseif ($puntuacion >= 30) {
            return "Compatibilidad moderada. Requerirá esfuerzo y comunicación para superar las diferencias, pero el potencial existe." . $motivosStr;
        } else {
            return "Baja compatibilidad. Sus energías astrológicas podrían chocar con frecuencia, exigiendo gran comprensión." . $motivosStr;
        }
    }

    /**
     * Genera un análisis detallado basado en la puntuación y los análisis individuales.
     *
     * @param float $puntuacion
     * @param array $analisisDetallado
     * @param SignoZodiacal|null $solar1
     * @param SignoZodiacal|null $solar2
     * @return string
     */
    protected function generateDetailedAnalysis(float $puntuacion, array $analisisDetallado, ?SignoZodiacal $solar1, ?SignoZodiacal $solar2): string
    {
        $intro = "Este análisis de compatibilidad astrológica evalúa la interacción entre las energías de " .
                 ($this->user1->nombre_completo ?? 'Usuario 1') . " y " . ($this->user2->nombre_completo ?? 'Usuario 2') . ".";

        $summary = "La puntuación general de {$puntuacion}% indica ";
        if ($puntuacion >= 85) {
            $summary .= "una extraordinaria alineación cósmica. Hay una resonancia profunda que facilita la comprensión y el apoyo mutuo.";
        } elseif ($puntuacion >= 70) {
            $summary .= "una fuerte conexión astrológica. Las bases para una relación armoniosa están bien establecidas, con energías que se complementan eficazmente.";
        } elseif ($puntuacion >= 50) {
            $summary .= "un potencial significativo para la conexión, aunque con áreas que requerirán atención y compromiso. Las diferencias pueden ser oportunidades de crecimiento.";
        } elseif ($puntuacion >= 30) {
            $summary .= "que la relación podría enfrentar desafíos. Las energías pueden chocar, requiriendo un esfuerzo consciente para la adaptación y la comprensión.";
        } else {
            $summary .= "que hay diferencias astrológicas considerables. Esto no significa que una relación sea imposible, pero demandará mucha paciencia, comunicación y respeto por las perspectivas del otro.";
        }

        $individualAnalyses = implode("\n- ", $analisisDetallado);
        if (!empty($individualAnalyses)) {
            $individualAnalyses = "\n\nDesglose de la compatibilidad:\n- " . $individualAnalyses;
        }

        $solarSummary = '';
        if ($solar1 && $solar2) {
            $solarSummary .= "\n\nEn cuanto a sus signos solares (" . $solar1->nombre_signo . " y " . $solar2->nombre_signo . "): ";
            if ($solar1->id_signo === $solar2->id_signo) {
                $solarSummary .= "Comparten la misma esencia, lo que puede llevar a una profunda comprensión o, a veces, a una falta de desafío. ";
            } elseif ($this->isOppositeSign($solar1, $solar2)) {
                $solarSummary .= "Son signos opuestos, lo que genera una fuerte atracción y la posibilidad de complementarse mutuamente, llenando los vacíos del otro. ";
            } elseif ($solar1->elemento === $solar2->elemento) {
                $solarSummary .= "Pertenecen al mismo elemento, lo que indica una forma similar de operar y sentir la vida. ";
            } else {
                $solarSummary .= "Sus signos solares, aunque diferentes, aportan dinámicas únicas a la relación. ";
            }
        } else {
            $solarSummary .= "\n\nNo se pudieron evaluar completamente los signos solares para un análisis más profundo.";
        }


        $conclusion = "\n\nRecuerda que la astrología es una guía. La comunicación, el respeto y el compromiso son fundamentales para cualquier relación exitosa, independientemente de la compatibilidad astrológica.";

        return $intro . "\n\n" . $summary . $individualAnalyses . $solarSummary . $conclusion;
    }

    /**
     * Helper para verificar si dos signos son opuestos.
     * @param SignoZodiacal $signo1
     * @param SignoZodiacal $signo2
     * @return bool
     */
    protected function isOppositeSign(SignoZodiacal $signo1, SignoZodiacal $signo2): bool
    {
        $opuestos = [
            1 => 7, 2 => 8, 3 => 9, 4 => 10, 5 => 11, 6 => 12,
            7 => 1, 8 => 2, 9 => 3, 10 => 4, 11 => 5, 12 => 6
        ];
        return (isset($opuestos[$signo1->id_signo]) && $opuestos[$signo1->id_signo] === $signo2->id_signo);
    }
}