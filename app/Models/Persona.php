<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Persona extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellidos',
        'ci',
        'emisora_id',
    ];

    /**
     * Obtener la emisora a la que pertenece la persona
     */
    public function emisora(): BelongsTo
    {
        return $this->belongsTo(Emisora::class);
    }

    /**
     * Obtener el teléfono asignado a la persona
     */
    public function telefono(): HasOne
    {
        return $this->hasOne(Telefono::class);
    }

    /**
     * Obtener la línea asignada a la persona
     */
    public function linea(): HasOne
    {
        return $this->hasOne(Linea::class);
    }

    /**
     * Obtener el nombre completo de la persona
     */
    public function getNombreCompletoAttribute(): string
    {
        return $this->nombre . ' ' . $this->apellidos;
    }
}