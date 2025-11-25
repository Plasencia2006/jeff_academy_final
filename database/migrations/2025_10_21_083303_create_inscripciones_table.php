<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jugador_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('entrenador_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('disciplina');
            $table->string('categoria');
            $table->string('tipo_entrenamiento');
            $table->date('fecha');
            $table->text('observaciones')->nullable();
            $table->string('estado')->default('pendiente');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscripciones');
    }
};