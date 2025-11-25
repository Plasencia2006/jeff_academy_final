<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    use HasFactory;

    // ✅ Fuerza el nombre real de la tabla
    protected $table = 'observaciones';

    // ✅ Habilita asignación masiva de estos campos
    protected $fillable = [
        'inscripcion_id',
        'fecha',
        'aspecto',
        'detalle',
        'recomendaciones',
    ];

    // (opcional) relación
    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class); // si tienes el modelo
    }
}
