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
        Schema::create('usuario_equipos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('equipos_o_elementos_id')->constrained('equipos_o_elementos')->onDelete('cascade')->onUpdate('cascade');
            
            $table->unique(['usuario_id', 'equipos_o_elementos_id'], 'unique_usuario_equipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_equipos');
    }
};
