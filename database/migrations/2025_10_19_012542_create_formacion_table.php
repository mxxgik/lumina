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
            $table->foreignId('nivel_formacion_id')->constrained('nivel_formacion')->onDelete('cascade')->onUpdate('cascade');
            $table->string('ficha')->nullable();
            $table->string('nombre_programa')->nullable();
            $table->date('fecha_inicio_programa')->nullable();
            $table->date('fecha_fin_programa')->nullable();
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
