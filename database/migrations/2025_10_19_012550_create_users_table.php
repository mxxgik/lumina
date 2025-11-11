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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('formacion_id')->nullable()->constrained('formacion')->onDelete('set null')->onUpdate('cascade');
            $table->string('nombre')->nullable();
            $table->string('apellido')->nullable();
            $table->string('tipo_documento', 50)->nullable();
            $table->string('documento', 50)->nullable();
            $table->integer('edad')->nullable();
            $table->string('numero_telefono', 20)->nullable();
            $table->text('path_foto')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
