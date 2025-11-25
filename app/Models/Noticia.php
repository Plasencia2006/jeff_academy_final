<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    protected $fillable = [
        'titulo',
        'descripcion',
        'categoria',
        'imagen',
        'fecha'
    ];

    protected $casts = [
        'fecha' => 'date',
    ];
}