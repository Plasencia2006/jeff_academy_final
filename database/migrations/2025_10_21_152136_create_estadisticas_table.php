<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estadisticas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inscripcion_id')->constrained('inscripciones')->onDelete('cascade');
            $table->date('fecha');
            $table->string('posicion')->nullable();
            $table->string('categoria')->nullable();
            
            // Estadísticas defensivas
            $table->integer('atajadas')->default(0);
            $table->integer('despejes')->default(0);
            $table->integer('recuperaciones')->default(0);
            $table->integer('intercepciones')->default(0);
            $table->integer('entradas')->default(0);
            
            // Estadísticas ofensivas
            $table->integer('pases_completos')->default(0);
            $table->integer('asistencias')->default(0);
            $table->integer('goles')->default(0);
            $table->integer('tiros_arco')->default(0);
            
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estadisticas');
    }
};
