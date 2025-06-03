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
        Schema::create('usuario_tags', function (Blueprint $table) {
            $table->id('id_usuario_tag');
            $table->foreignId('id_usuario')->constrained('astrological_users')->onDelete('cascade');
            $table->foreignId('id_tag')->constrained('tags_maestros', 'id_tag');
            $table->timestamp('fecha_asignacion')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unique(['id_usuario', 'id_tag']);
            $table->timestamps(); // Opcional, para mantener un registro de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario_tags');
    }
};