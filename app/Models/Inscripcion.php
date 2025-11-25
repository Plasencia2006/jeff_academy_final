<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;
    protected $table = 'inscripciones';


    protected $fillable = [
        'jugador_id',
        'entrenador_id',
        'disciplina',
        'categoria',
        'tipo_entrenamiento',
        'fecha',
        'observaciones',
        'estado',
    ];

    /**
     * Relación: una inscripción pertenece a un jugador (usuario con rol 'player')
     */
    public function jugador()
    {
        return $this->belongsTo(User::class, 'jugador_id');
    }

    /**
     * Relación: una inscripción pertenece a un entrenador (usuario con rol 'coach')
     */
    public function entrenador()
    {
        return $this->belongsTo(User::class, 'entrenador_id');
    }

    /**
     * Relación: una inscripción puede tener muchas asistencias registradas
     */
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'inscripcion_id');
    }

    /**
     * Relación: una inscripción puede tener muchas estadísticas deportivas
     */
    public function estadisticas()
    {
        return $this->hasMany(Estadistica::class, 'inscripcion_id');
    }
}
