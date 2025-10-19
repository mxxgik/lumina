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
        Schema::create('historial_elementos_adicionales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('historial_id')->constrained('historial')->onDelete('cascade');
            $table->foreignId('aprendiz_elemento_adicional_id')->references('id')->on('aprendiz_elementos_adicionales')->onDelete('cascade')->name('hea_aprendiz_elemento_adicional_id_foreign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_elementos_adicionales');
    }
};
