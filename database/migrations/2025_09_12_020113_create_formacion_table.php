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
        Schema::create('formacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aprendiz_id')->constrained('aprendiz')->onDelete('cascade');
            $table->foreignId('tipos_programas_id')->constrained('tipos_programas')->onDelete('cascade');
            $table->string('ficha');
            $table->string('nombre_programa');
            $table->date('fecha_inicio_programa');
            $table->date('fecha_fin_programa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formacion');
    }
};
