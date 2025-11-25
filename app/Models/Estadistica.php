<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estadistica extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional si sigue la convención de Laravel)
    protected $table = 'estadisticas';

    // Campos que se pueden llenar masivamente (Mass Assignment)
    protected $fillable = [
        'inscripcion_id',
        'fecha',
        'posicion',
        'categoria',
        // Estadísticas defensivas
        'atajadas',
        'despejes',
        'recuperaciones',
        'intercepciones',
        'entradas',
        // Estadísticas ofensivas
        'pases_completos',
        'asistencias',
        'goles',
        'tiros_arco',
        // Observaciones
        'observaciones'
    ];

    // Campos que deben ser tratados como fechas
    protected $casts = [
        'fecha' => 'date',
        'atajadas' => 'integer',
        'despejes' => 'integer',
        'recuperaciones' => 'integer',
        'intercepciones' => 'integer',
        'entradas' => 'integer',
        'pases_completos' => 'integer',
        'asistencias' => 'integer',
        'goles' => 'integer',
        'tiros_arco' => 'integer',
    ];

    /**
     * Relación con Inscripcion
     * Una estadística pertenece a una inscripción
     */
    public function inscripcion()
    {
        return $this->belongsTo(\App\Models\Inscripcion::class);
    }

    /**
     * Relación indirecta con el jugador a través de la inscripción
     */
    public function jugador()
    {
        return $this->hasOneThrough(
            \App\Models\User::class,
            \App\Models\Inscripcion::class,
            'id',              // Foreign key en inscripcions
            'id',              // Foreign key en users
            'inscripcion_id',  // Local key en estadisticas
            'jugador_id'       // Local key en inscripcions
        );
    }
}
