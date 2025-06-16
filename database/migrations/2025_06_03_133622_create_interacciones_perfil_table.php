<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('interacciones_perfil', function (Blueprint $table) {
            $table->id('id_interaccion');
            $table->foreignId('id_emisor')->constrained('astrological_users')->onDelete('cascade');
            $table->foreignId('id_receptor')->constrained('astrological_users')->onDelete('cascade');
            // --- AJUSTE RECOMENDADO ---
            $table->enum('tipo_interaccion', ['like', 'dislike', 'vista']); 
            $table->timestamp('fecha_interaccion')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unique(['id_emisor', 'id_receptor', 'tipo_interaccion'], 'idx_interaccion_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('interacciones_perfil');
    }
};