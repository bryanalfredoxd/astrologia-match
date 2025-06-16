<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('emparejamientos', function (Blueprint $table) {
            $table->id('id_emparejamiento');
            $table->foreignId('usuario1_id')->constrained('astrological_users')->onDelete('cascade');
            $table->foreignId('usuario2_id')->constrained('astrological_users')->onDelete('cascade');
            $table->enum('estado', ['activo', 'deshecho'])->default('activo');
            $table->timestamp('fecha_emparejamiento')->useCurrent();
            $table->timestamps(); // created_at y updated_at

            // Índice único para evitar matches duplicados (A-B y B-A)
            $table->unique(['usuario1_id', 'usuario2_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('emparejamientos');
    }
};