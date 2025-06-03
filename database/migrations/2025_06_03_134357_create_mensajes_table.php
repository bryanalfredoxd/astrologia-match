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
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id('id_mensaje');
            $table->foreignId('id_remitente')->constrained('astrological_users')->onDelete('cascade');
            $table->foreignId('id_receptor')->constrained('astrological_users')->onDelete('cascade');
            $table->text('contenido');
            $table->timestamp('fecha_envio')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->boolean('leido')->default(false);
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
        Schema::dropIfExists('mensajes');
    }
};