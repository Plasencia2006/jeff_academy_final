<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrenamiento extends Model
{
    protected $fillable = [
        'nombre',
        'disciplina',
        'categoria',
        'tipo',
        'fecha',
        'hora',
        'duracion',
        'ubicacion',
        'objetivos',
        'entrenador_id'
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function entrenador()
    {
        return $this->belongsTo(User::class, 'entrenador_id');
    }
}
