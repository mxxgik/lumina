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
        Schema::create('equipos_o_elementos', function (Blueprint $table) {
            $table->id();
            $table->string('sn_equipo');
            $table->string('marca');
            $table->string('color');
            $table->string('tipo_elemento');
            $table->string('path_qr');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos_o_elementos');
    }
};
