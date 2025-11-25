<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;
    
    protected $table = 'planes';
    
    protected $fillable = [
        'nombre', 
        'precio', 
        'duracion', 
        'tipo', 
        'descripcion', 
        'beneficios', 
        'disciplinas', 
        'estado'
    ];
    
    protected $casts = [
        'precio' => 'decimal:2',
        'duracion' => 'integer',
    ];

    // Relación con suscripciones
    public function subscriptions()
    {
        return $this->hasMany(PlanSubscription::class);
    }

    // Accesor para obtener las disciplinas como array de IDs
    public function getDisciplinasArrayAttribute()
    {
        return $this->disciplinas ? explode(',', $this->disciplinas) : [];
    }

    // Relación con las disciplinas
    public function disciplinasRelacionadas()
    {
        return Disciplina::whereIn('id', $this->disciplinasArray)->get();
    }

    // Accesor para obtener nombres de disciplinas
    public function getNombresDisciplinasAttribute()
    {
        $disciplinas = $this->disciplinasRelacionadas();
        return $disciplinas->pluck('nombre')->implode(', ');
    }

    // Verificar si el plan está activo
    public function getEstaActivoAttribute()
    {
        return $this->estado === 'activo';
    }

    // Obtener duración en texto
    public function getDuracionTextoAttribute()
    {
        return $this->duracion . ' ' . ($this->duracion == 1 ? 'mes' : 'meses');
    }

    // Formatear precio
    public function getPrecioFormateadoAttribute()
    {
        return '$' . number_format($this->precio, 2);
    }
}