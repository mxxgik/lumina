<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('historial', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aprendiz_id')->constrained('aprendiz')->onDelete('cascade');
            $table->foreignId('equipos_o_elementos_id')->constrained('equipos_o_elementos')->onDelete('cascade');
            $table->foreignId('elementos_adicionales_aprendiz_id')->constrained('elementos_adicionales_aprendiz')->onDelete('cascade');
            $table->date('fecha');
            $table->time('hora_ingreso');
            $table->time('hora_salida');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial');
    }
};
