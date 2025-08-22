<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paquete extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'cantidad_datos',
        'cantidad_minutos',
        'cantidad_sms',
        'precio_costo',
        'descripcion',
    ];

    protected $casts = [
        'precio_costo' => 'decimal:2',
        'cantidad_datos' => 'integer',
        'cantidad_minutos' => 'integer',
        'cantidad_sms' => 'integer',
    ];

    /**
     * Obtener las líneas que tienen asignado este paquete
     */
    public function lineas(): HasMany
    {
        return $this->hasMany(Linea::class);
    }

    /**
     * Obtener el precio formateado
     */
    public function getPrecioFormateadoAttribute(): string
    {
        return '$' . number_format($this->precio_costo, 2);
    }

    /**
     * Obtener la descripción del paquete
     */
    public function getDescripcionCompletaAttribute(): string
    {
        return "{$this->cantidad_datos}GB, {$this->cantidad_minutos} min, {$this->cantidad_sms} SMS";
    }
}