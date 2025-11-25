<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disciplina extends Model
{
    protected $table = 'disciplinas';

    protected $fillable = [
        'nombre',
        'categoria',
        'edad_minima',
        'edad_maxima',
        'cupo_maximo',
        'descripcion',
        'requisitos',
        'estado',
        'imagen',
    ];
}
