<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('astrological_users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_completo');
            $table->string('email')->unique();
            $table->string('password');
            $table->date('fecha_nacimiento');
            $table->time('hora_nacimiento');
            $table->string('lugar_nacimiento');
            $table->string('genero');
            $table->string('orientacion_sexual');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('astrological_users');
    }
};