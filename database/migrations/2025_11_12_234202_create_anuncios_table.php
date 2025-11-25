<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anuncios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('coach_id')->constrained('users')->onDelete('cascade');
            $table->string('titulo');
            $table->text('mensaje');
            $table->string('categoria')->nullable();
            $table->enum('audiencia', ['todos', 'categoria'])->default('todos');
            $table->string('enlace')->nullable();
            $table->date('vigente_hasta')->nullable();
            $table->enum('prioridad', ['normal', 'importante', 'urgente'])->default('normal');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anuncios');
    }
};
