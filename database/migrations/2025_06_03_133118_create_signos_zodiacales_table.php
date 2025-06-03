<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Para la inserción de datos

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signos_zodiacales', function (Blueprint $table) {
            $table->id('id_signo'); // Laravel automáticamente asigna 'id' como primary key, aquí lo renombramos
            $table->string('nombre_signo', 50)->unique();
            $table->enum('elemento', ['Fuego', 'Tierra', 'Aire', 'Agua']);
            $table->enum('modalidad', ['Cardinal', 'Fijo', 'Mutable']);
        });

        // Insertar los datos de los signos zodiacales
        DB::table('signos_zodiacales')->insert([
            ['nombre_signo' => 'Aries', 'elemento' => 'Fuego', 'modalidad' => 'Cardinal'],
            ['nombre_signo' => 'Tauro', 'elemento' => 'Tierra', 'modalidad' => 'Fijo'],
            ['nombre_signo' => 'Géminis', 'elemento' => 'Aire', 'modalidad' => 'Mutable'],
            ['nombre_signo' => 'Cáncer', 'elemento' => 'Agua', 'modalidad' => 'Cardinal'],
            ['nombre_signo' => 'Leo', 'elemento' => 'Fuego', 'modalidad' => 'Fijo'],
            ['nombre_signo' => 'Virgo', 'elemento' => 'Tierra', 'modalidad' => 'Mutable'],
            ['nombre_signo' => 'Libra', 'elemento' => 'Aire', 'modalidad' => 'Cardinal'],
            ['nombre_signo' => 'Escorpio', 'elemento' => 'Agua', 'modalidad' => 'Fijo'],
            ['nombre_signo' => 'Sagitario', 'elemento' => 'Fuego', 'modalidad' => 'Mutable'],
            ['nombre_signo' => 'Capricornio', 'elemento' => 'Tierra', 'modalidad' => 'Cardinal'],
            ['nombre_signo' => 'Acuario', 'elemento' => 'Aire', 'modalidad' => 'Fijo'],
            ['nombre_signo' => 'Piscis', 'elemento' => 'Agua', 'modalidad' => 'Mutable'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('signos_zodiacales');
    }
};