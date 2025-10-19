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
        Schema::create('aprendiz_elementos_adicionales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aprendiz_id')->constrained('aprendiz')->onDelete('cascade');
            $table->foreignId('elementos_adicionales_id')->constrained('elementos_adicionales')->onDelete('cascade');
            
            $table->unique(['aprendiz_id', 'elementos_adicionales_id'], 'unique_aprendiz_elemento_adicional');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aprendiz_elementos_adicionales');
    }
};
