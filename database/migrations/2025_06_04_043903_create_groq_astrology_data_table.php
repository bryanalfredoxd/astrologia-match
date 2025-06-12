<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groq_astrology_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('astrological_users')->onDelete('cascade'); // Llave foránea al usuario, única para relación 1:1
            $table->foreignId('signo_lunar_id')->nullable()->constrained('signos_zodiacales', 'id_signo'); // Llave foránea al signo lunar
            $table->foreignId('signo_ascendente_id')->nullable()->constrained('signos_zodiacales', 'id_signo'); // Llave foránea al signo ascendente
            $table->timestamps(); // Para created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groq_astrology_data');
    }
};