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
        Schema::create('aprendiz_equipos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aprendiz_id')->constrained('aprendiz')->onDelete('cascade');
            $table->foreignId('equipos_o_elementos_id')->constrained('equipos_o_elementos')->onDelete('cascade');
            
            $table->unique(['aprendiz_id', 'equipos_o_elementos_id'], 'unique_aprendiz_equipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aprendiz_equipos');
    }
};
