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
        Schema::create('compatibilidad', function (Blueprint $table) {
            $table->id('id_compatibilidad');
            $table->foreignId('id_usuario1')->constrained('astrological_users')->onDelete('cascade');
            $table->foreignId('id_usuario2')->constrained('astrological_users')->onDelete('cascade');
            $table->decimal('puntuacion_general', 5, 2)->nullable();
            $table->string('descripcion_breve', 500)->nullable();
            $table->text('analisis_detallado')->nullable();
            $table->timestamp('fecha_calculo')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unique(['id_usuario1', 'id_usuario2']);
            $table->timestamps(); // Opcional
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compatibilidad');
    }
};