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
        Schema::create('tags_maestros', function (Blueprint $table) {
            $table->id('id_tag');
            $table->string('nombre_tag', 100)->unique();
            $table->string('categoria', 50);
        });

        // Insertar los datos de los tags maestros
        DB::table('tags_maestros')->insert([
            // Estado civil/sentimental
            ['nombre_tag' => 'Soltero/a', 'categoria' => 'Estado Civil/Sentimental'],
            ['nombre_tag' => 'En una relación abierta', 'categoria' => 'Estado Civil/Sentimental'],
            ['nombre_tag' => 'Viudo/a', 'categoria' => 'Estado Civil/Sentimental'],
            ['nombre_tag' => 'Divorciado/a', 'categoria' => 'Estado Civil/Sentimental'],
            ['nombre_tag' => 'Separado/a', 'categoria' => 'Estado Civil/Sentimental'],
            ['nombre_tag' => 'Complicado', 'categoria' => 'Estado Civil/Sentimental'],
            // Estudio
            ['nombre_tag' => 'Estudiante universitario', 'categoria' => 'Estudio'],
            ['nombre_tag' => 'Posgrado', 'categoria' => 'Estudio'],
            ['nombre_tag' => 'Estudiando algo más', 'categoria' => 'Estudio'],
            // Trabajo
            ['nombre_tag' => 'Trabajando a tiempo completo', 'categoria' => 'Trabajo'],
            ['nombre_tag' => 'Trabajando a tiempo parcial', 'categoria' => 'Trabajo'],
            ['nombre_tag' => 'Buscando empleo', 'categoria' => 'Trabajo'],
            ['nombre_tag' => 'Autónomo/a', 'categoria' => 'Trabajo'],
            // Tipo de relación
            ['nombre_tag' => 'Busco relación seria', 'categoria' => 'Tipo de Relación'],
            ['nombre_tag' => 'Busco algo casual', 'categoria' => 'Tipo de Relación'],
            ['nombre_tag' => 'Busco amistad', 'categoria' => 'Tipo de Relación'],
            ['nombre_tag' => 'No estoy seguro/a', 'categoria' => 'Tipo de Relación'],
            // Buscando
            ['nombre_tag' => 'Pareja', 'categoria' => 'Buscando'],
            ['nombre_tag' => 'Amigos', 'categoria' => 'Buscando'],
            ['nombre_tag' => 'Ambos', 'categoria' => 'Buscando'],
            // Intereses (ejemplos)
            ['nombre_tag' => 'Deportes', 'categoria' => 'Intereses'],
            ['nombre_tag' => 'Música', 'categoria' => 'Intereses'],
            ['nombre_tag' => 'Cine y TV', 'categoria' => 'Intereses'],
            ['nombre_tag' => 'Lectura', 'categoria' => 'Intereses'],
            ['nombre_tag' => 'Videojuegos', 'categoria' => 'Intereses'],
            ['nombre_tag' => 'Viajar', 'categoria' => 'Intereses'],
            ['nombre_tag' => 'Cocinar', 'categoria' => 'Intereses'],
            ['nombre_tag' => 'Naturaleza', 'categoria' => 'Intereses'],
            ['nombre_tag' => 'Arte', 'categoria' => 'Intereses'],
            ['nombre_tag' => 'Tecnología', 'categoria' => 'Intereses'],
            ['nombre_tag' => 'Moda', 'categoria' => 'Intereses'],
            ['nombre_tag' => 'Fotografía', 'categoria' => 'Intereses'],
            // Idiomas (ejemplos)
            ['nombre_tag' => 'Español', 'categoria' => 'Idiomas'],
            ['nombre_tag' => 'Inglés', 'categoria' => 'Idiomas'],
            ['nombre_tag' => 'Portugués', 'categoria' => 'Idiomas'],
            ['nombre_tag' => 'Francés', 'categoria' => 'Idiomas'],
            // Ejercicio
            ['nombre_tag' => 'Activo', 'categoria' => 'Ejercicio'],
            ['nombre_tag' => 'Ocasional', 'categoria' => 'Ejercicio'],
            ['nombre_tag' => 'No hago ejercicio', 'categoria' => 'Ejercicio'],
            // Bebe
            ['nombre_tag' => 'Socialmente', 'categoria' => 'Bebe'],
            ['nombre_tag' => 'Frecuentemente', 'categoria' => 'Bebe'],
            ['nombre_tag' => 'No bebo', 'categoria' => 'Bebe'],
            // Fuma
            ['nombre_tag' => 'Sí', 'categoria' => 'Fuma'],
            ['nombre_tag' => 'No', 'categoria' => 'Fuma'],
            ['nombre_tag' => 'Ocasionalmente', 'categoria' => 'Fuma'],
            // Religión
            ['nombre_tag' => 'Cristianismo', 'categoria' => 'Religión'],
            ['nombre_tag' => 'Islam', 'categoria' => 'Religión'],
            ['nombre_tag' => 'Judaísmo', 'categoria' => 'Religión'],
            ['nombre_tag' => 'Budismo', 'categoria' => 'Religión'],
            ['nombre_tag' => 'Hinduismo', 'categoria' => 'Religión'],
            ['nombre_tag' => 'Agnóstico', 'categoria' => 'Religión'],
            ['nombre_tag' => 'Ateo', 'categoria' => 'Religión'],
            ['nombre_tag' => 'Espiritual', 'categoria' => 'Religión'],
            ['nombre_tag' => 'Prefiero no decirlo', 'categoria' => 'Religión'],
            // Niños
            ['nombre_tag' => 'Tengo hijos', 'categoria' => 'Niños'],
            ['nombre_tag' => 'No tengo hijos, pero quiero', 'categoria' => 'Niños'],
            ['nombre_tag' => 'No tengo hijos y no quiero', 'categoria' => 'Niños'],
            // Nivel Educativo
            ['nombre_tag' => 'Educación secundaria', 'categoria' => 'Nivel Educativo'],
            ['nombre_tag' => 'Técnico superior', 'categoria' => 'Nivel Educativo'],
            ['nombre_tag' => 'Grado universitario', 'categoria' => 'Nivel Educativo'],
            ['nombre_tag' => 'Máster', 'categoria' => 'Nivel Educativo'],
            ['nombre_tag' => 'Doctorado', 'categoria' => 'Nivel Educativo'],
            ['nombre_tag' => 'Autodidacta', 'categoria' => 'Nivel Educativo'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags_maestros');
    }
};