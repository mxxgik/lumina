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
        Schema::create('equipo_elemento_adicional', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipos_o_elementos_id')->constrained('equipos_o_elementos')->onDelete('cascade');
            $table->foreignId('elementos_adicionales_id')->constrained('elementos_adicionales')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['equipos_o_elementos_id', 'elementos_adicionales_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipo_elemento_adicional');
    }
};
