<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('email', 100)->unique();
            $table->string('contrasena', 255);
            $table->date('fecha_nacimiento');
            $table->enum('genero', ['Masculino', 'Femenino']);

            $table->string('signo_solar', 20)->nullable();
            $table->string('signo_lunar', 20)->nullable();
            $table->string('signo_ascendente', 20)->nullable();

            $table->timestamp('fecha_registro')->useCurrent();
            $table->timestamp('ultima_actividad')->nullable();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->string('foto_perfil')->nullable();
            $table->text('descripcion')->nullable();

            $table->string('ip_registro', 45)->nullable();
            $table->string('pais', 100)->nullable();
            $table->string('ciudad', 100)->nullable();
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();
            $table->string('ubicacion_manual', 255)->nullable();

            $table->boolean('trabaja')->nullable();

            $table->boolean('estudia')->nullable();
            $table->string('institucion', 100)->nullable();

            $table->enum('motivo', ['Amistad', 'Relación Seria', 'Casual'])->nullable();
            $table->decimal('altura', 4, 2)->nullable();
            $table->boolean('hijos')->nullable();
            $table->enum('bebe', ['Nunca', 'Ocasionalmente', 'Frecuentemente'])->nullable();
            $table->enum('fuma', ['No', 'Ocasionalmente', 'Frecuentemente'])->nullable();
            $table->text('idiomas')->nullable();
            $table->text('mascotas')->nullable();

            $table->enum('relacion_actual', ['Soltero', 'Casado', 'Divorciado', 'Viudo', 'En una relación', 'Abierta'])->nullable();
            $table->enum('sexualidad', ['Heterosexual', 'Homosexual'])->nullable();
            $table->string('religion', 50)->nullable();
            $table->enum('personalidad', ['Introvertido', 'Extrovertido', 'Intermedio'])->nullable();
            $table->enum('nivel_educativo', ['Primaria', 'Secundaria', 'Universitario', 'Postgrado'])->nullable();

            $table->enum('tipo_relacion', ['Casual', 'Seria', 'Amistad'])->nullable();
            $table->boolean('aceptar_hijos')->nullable();
            $table->boolean('dispuesto_mudarse')->nullable();
            $table->boolean('citas_virtuales')->nullable();

            $table->enum('tipo_cuerpo', ['Delgado', 'Atlético', 'Normal', 'Robusto'])->nullable();
            $table->enum('alimentacion', ['Omnívoro', 'Vegetariano', 'Vegano'])->nullable();
            $table->enum('actividad_fisica', ['Sedentario', 'Activo', 'Deportista'])->nullable();
            $table->text('valores')->nullable();
            $table->enum('ingresos', ['Bajo', 'Medio', 'Alto'])->nullable();
            $table->boolean('compartir_gastos')->nullable();
            $table->text('musica_favorita')->nullable();
            $table->text('entretenimiento')->nullable();
            $table->enum('estilo_comunicacion', ['Mensajes cortos', 'Mensajes largos', 'Llamadas'])->nullable();

            $table->enum('estado_cuenta', ['Activo', 'Suspendido', 'Eliminado'])->default('Activo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
}
