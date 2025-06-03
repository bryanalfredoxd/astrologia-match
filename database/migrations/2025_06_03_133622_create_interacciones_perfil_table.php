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
        Schema::create('interacciones_perfil', function (Blueprint $table) {
            $table->id('id_interaccion');
            $table->foreignId('id_emisor')->constrained('astrological_users')->onDelete('cascade');
            $table->foreignId('id_receptor')->constrained('astrological_users')->onDelete('cascade');
            $table->enum('tipo_interaccion', ['vista', 'aceptado', 'rechazado']);
            $table->timestamp('fecha_interaccion')->default(DB::raw('CURRENT_TIMESTAMP'));
            // MODIFICACIÓN AQUÍ: Especificamos un nombre más corto para el índice único
            $table->unique(['id_emisor', 'id_receptor', 'tipo_interaccion'], 'idx_interaccion_unique');
            // $table->timestamps(); // Opcional
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interacciones_perfil');
    }
};