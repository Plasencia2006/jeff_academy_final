<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Anuncio extends Model
{
    protected $fillable = [
        'titulo',
        'mensaje',
        'categoria',
        'audiencia',
        'enlace',
        'vigente_hasta',
        'prioridad',
        'activo',
        'coach_id'
    ];

    protected $casts = [
        'vigente_hasta' => 'date',
        'activo' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relación con el coach que creó el anuncio
     */
    public function coach(): BelongsTo
    {
        return $this->belongsTo(User::class, 'coach_id');
    }

    /**
     * Scope para anuncios activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para anuncios vigentes
     */
    public function scopeVigentes($query)
    {
        return $query->where(function($q) {
            $q->whereNull('vigente_hasta')
              ->orWhere('vigente_hasta', '>=', now()->toDateString());
        });
    }

    /**
     * Scope para anuncios por categoría
     */
    public function scopePorCategoria($query, $categoria)
    {
        if ($categoria) {
            return $query->where('categoria', $categoria);
        }
        return $query;
    }

    /**
     * Scope para anuncios importantes
     */
    public function scopeImportantes($query)
    {
        return $query->whereIn('prioridad', ['importante', 'urgente']);
    }

    /**
     * Verificar si el anuncio está vigente
     */
    public function getEsVigenteAttribute(): bool
    {
        if (!$this->vigente_hasta) {
            return true;
        }
        return $this->vigente_hasta >= now()->toDateString();
    }

    /**
     * Obtener el estado del anuncio
     */
    public function getEstadoAttribute(): string
    {
        if (!$this->activo) {
            return 'inactivo';
        }
        return $this->es_vigente ? 'vigente' : 'vencido';
    }

    /**
     * Obtener clase CSS según prioridad
     */
    public function getClasePrioridadAttribute(): string
    {
        return match($this->prioridad) {
            'urgente' => 'bg-red-100 text-red-800 border-red-200',
            'importante' => 'bg-orange-100 text-orange-800 border-orange-200',
            default => 'bg-blue-100 text-blue-800 border-blue-200'
        };
    }

    /**
     * Obtener icono según prioridad
     */
    public function getIconoPrioridadAttribute(): string
    {
        return match($this->prioridad) {
            'urgente' => 'fas fa-exclamation-triangle',
            'importante' => 'fas fa-exclamation-circle',
            default => 'fas fa-info-circle'
        };
    }
}
