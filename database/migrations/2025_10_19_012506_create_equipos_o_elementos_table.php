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
            $table->string('sn_equipo', 100)->nullable();
            $table->string('marca', 100)->nullable();
            $table->string('color', 100)->nullable();
            $table->string('tipo_elemento', 100)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('path_qr')->nullable();
            $table->text('path_foto_equipo_implemento')->nullable();
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
