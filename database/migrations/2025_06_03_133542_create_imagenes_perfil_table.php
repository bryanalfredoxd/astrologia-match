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
        Schema::create('imagenes_perfil', function (Blueprint $table) {
            $table->id('id_imagen');
            $table->foreignId('id_usuario')->constrained('astrological_users')->onDelete('cascade');
            $table->string('url_imagen', 500);
            $table->integer('orden')->default(0);
            $table->timestamp('fecha_subida')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('imagenes_perfil');
    }
};