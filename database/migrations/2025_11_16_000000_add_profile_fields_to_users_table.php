<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Imagen de perfil
            $table->string('foto_perfil')->nullable()->after('role');
            
            // Contacto e información personal
            $table->string('telefono', 20)->nullable()->after('foto_perfil');
            $table->text('direccion')->nullable()->after('telefono');
            $table->date('fecha_nacimiento')->nullable()->after('direccion');
            $table->text('biografia')->nullable()->after('fecha_nacimiento');
            $table->json('enlaces')->nullable()->after('biografia');
            
            // Datos físicos (jugadores)
            $table->decimal('altura', 5, 2)->nullable()->after('enlaces');
            $table->decimal('peso', 5, 2)->nullable()->after('altura');
            $table->string('posicion')->nullable()->after('peso');
            $table->string('categoria')->nullable()->after('posicion');
            $table->string('numero_jersey', 3)->nullable()->after('categoria');
            
            // Información profesional (coaches)
            $table->string('especialidad')->nullable()->after('numero_jersey');
            $table->integer('anos_experiencia')->nullable()->after('especialidad');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'foto_perfil',
                'telefono',
                'direccion',
                'fecha_nacimiento',
                'biografia',
                'enlaces',
                'altura',
                'peso',
                'posicion',
                'categoria',
                'numero_jersey',
                'especialidad',
                'anos_experiencia',
            ]);
        });
    }
};
