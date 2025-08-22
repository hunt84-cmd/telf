<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Telefono extends Model
{
    use HasFactory;

    protected $fillable = [
        'modelo',
        'estado_tecnico',
        'persona_id',
        'fecha_ingreso_almacen',
        'fecha_asignacion',
        'observaciones',
    ];

    protected $casts = [
        'fecha_ingreso_almacen' => 'datetime',
        'fecha_asignacion' => 'datetime',
    ];

    // Estados técnicos disponibles
    const ESTADO_BUENO = 'Bueno';
    const ESTADO_DANADO = 'Dañado';
    const ESTADO_ROTO = 'Roto';

    /**
     * Obtener los estados técnicos disponibles
     */
    public static function getEstadosTecnicos(): array
    {
        return [
            self::ESTADO_BUENO,
            self::ESTADO_DANADO,
            self::ESTADO_ROTO,
        ];
    }

    /**
     * Obtener la persona a la que está asignado el teléfono
     */
    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class);
    }

    /**
     * Verificar si el teléfono está en almacén
     */
    public function isEnAlmacen(): bool
    {
        return is_null($this->persona_id);
    }

    /**
     * Verificar si el teléfono está asignado
     */
    public function isAsignado(): bool
    {
        return !is_null($this->persona_id);
    }

    /**
     * Obtener el estado del teléfono (En almacén o Asignado)
     */
    public function getEstadoAsignacionAttribute(): string
    {
        return $this->isEnAlmacen() ? 'En almacén' : 'Asignado';
    }
}