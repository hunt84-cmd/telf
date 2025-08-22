<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Linea extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_telefono',
        'pin',
        'puk',
        'persona_id',
        'paquete_id',
        'fecha_ingreso_almacen',
        'fecha_asignacion',
        'estado',
        'observaciones',
    ];

    protected $casts = [
        'fecha_ingreso_almacen' => 'datetime',
        'fecha_asignacion' => 'datetime',
    ];

    // Estados de la línea
    const ESTADO_ACTIVA = 'Activa';
    const ESTADO_INACTIVA = 'Inactiva';
    const ESTADO_SUSPENDIDA = 'Suspendida';

    /**
     * Obtener los estados disponibles
     */
    public static function getEstados(): array
    {
        return [
            self::ESTADO_ACTIVA,
            self::ESTADO_INACTIVA,
            self::ESTADO_SUSPENDIDA,
        ];
    }

    /**
     * Obtener la persona a la que está asignada la línea
     */
    public function persona(): BelongsTo
    {
        return $this->belongsTo(Persona::class);
    }

    /**
     * Obtener el paquete asignado a la línea
     */
    public function paquete(): BelongsTo
    {
        return $this->belongsTo(Paquete::class);
    }

    /**
     * Verificar si la línea está en almacén
     */
    public function isEnAlmacen(): bool
    {
        return is_null($this->persona_id);
    }

    /**
     * Verificar si la línea está asignada
     */
    public function isAsignada(): bool
    {
        return !is_null($this->persona_id);
    }

    /**
     * Obtener el estado de asignación de la línea
     */
    public function getEstadoAsignacionAttribute(): string
    {
        return $this->isEnAlmacen() ? 'En almacén' : 'Asignada';
    }

    /**
     * Verificar si la línea tiene paquete asignado
     */
    public function hasPaquete(): bool
    {
        return !is_null($this->paquete_id);
    }
}