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
    Schema::create('productos', function (Blueprint $table) {
        $table->id(); // ID único
        $table->string('codigo')->nullable();
        $table->string('nombre');
        $table->string('marca')->nullable();
        $table->string('modelo')->nullable();
        $table->string('medidas')->nullable();
        $table->string('unidades')->nullable();
        $table->string('tipo')->nullable();
        $table->text('descripcion')->nullable();
        $table->timestamps(); // Crea 'created_at' y 'updated_at'
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
