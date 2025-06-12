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
        Schema::create('user_distances', function (Blueprint $table) {
            $table->id('id_distancia');
            $table->foreignId('id_usuario1')->constrained('astrological_users')->onDelete('cascade');
            $table->foreignId('id_usuario2')->constrained('astrological_users')->onDelete('cascade');
            $table->decimal('distancia_km', 10, 2)->nullable(); // Distancia en kilómetros
            $table->timestamp('fecha_calculo')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unique(['id_usuario1', 'id_usuario2']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_distances');
    }
};