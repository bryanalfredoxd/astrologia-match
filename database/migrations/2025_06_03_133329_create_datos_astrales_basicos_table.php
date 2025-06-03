<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datos_astrales_basicos', function (Blueprint $table) {
            $table->id('id_datos_astrales');
            $table->foreignId('id_usuario')->unique()->constrained('astrological_users')->onDelete('cascade'); // Relación 1:1 con astrological_users
            $table->foreignId('id_signo_solar')->constrained('signos_zodiacales', 'id_signo');
            $table->foreignId('id_signo_lunar')->constrained('signos_zodiacales', 'id_signo');
            $table->foreignId('id_ascendente')->constrained('signos_zodiacales', 'id_signo');
            $table->timestamp('fecha_calculo')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datos_astrales_basicos');
    }
};