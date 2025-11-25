<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entrenamientos', function (Blueprint $table) {
            $table->id();
            
            // Relación con el entrenador (coach)
            $table->foreignId('entrenador_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
            
            $table->string('nombre');
            $table->string('disciplina');
            $table->string('categoria');
            $table->string('tipo');
            $table->date('fecha');
            $table->time('hora');
            $table->integer('duracion');
            $table->string('ubicacion');
            $table->text('objetivos');
            $table->timestamps();
            
            // Índices
            $table->index('fecha');
            $table->index('categoria');
            $table->index('entrenador_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entrenamientos');
    }
};