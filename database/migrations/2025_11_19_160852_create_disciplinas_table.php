<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
 public function up()
    {
        Schema::create('disciplinas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('categoria', ['Fútbol', 'Voley']);
            $table->integer('edad_minima')->nullable();
            $table->integer('edad_maxima')->nullable();
            $table->integer('cupo_maximo')->nullable();
            $table->text('descripcion')->nullable();
            $table->text('requisitos')->nullable();
            $table->enum('estado', ['activa', 'inactiva'])->default('activa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplinas');
    }
};
