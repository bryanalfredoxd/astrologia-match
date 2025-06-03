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
            // Campos de geolocalización
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();
            // Campos adicionales
            $table->text('biografia')->nullable();
            $table->string('foto_perfil_url', 500)->nullable();
            // Campos de estado y verificación (opcionales con valores por defecto)
            $table->boolean('activo')->default(true);
            $table->timestamp('email_verificado_at')->nullable();

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('astrological_users');
    }
};