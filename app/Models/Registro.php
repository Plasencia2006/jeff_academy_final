<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    protected $fillable = [
        'tipo_documento',
        'nro_documento',
        'genero',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'fecha_nacimiento',
        'nro_celular',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

      // Relación con el jugador
    public function jugador()
    {
        return $this->belongsTo(User::class, 'jugador_id');
    }

    // Relación con el plan
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    // Relación con el entrenador
    public function entrenador()
    {
        return $this->belongsTo(User::class, 'entrenador_id');
    }
}
