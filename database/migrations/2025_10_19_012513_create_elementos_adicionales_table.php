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
            $table->string('tipo_elemento', 100)->nullable();
            $table->string('nombre_elemento', 100)->nullable();
            $table->text('path_foto_elemento')->nullable();
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
