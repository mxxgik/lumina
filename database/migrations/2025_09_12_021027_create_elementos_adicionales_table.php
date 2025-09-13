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
        Schema::create('elementos_adicionales', function (Blueprint $table) {
            $table->id();
            $table->string('tipos_elementos_adicionales');  //herramientas, tecnologia etc...
            $table->string('nombre_elemento_adicionales');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elementos_adicionales');
    }
};
