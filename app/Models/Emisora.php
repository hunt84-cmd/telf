<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Emisora extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'responsable',
    ];

    /**
     * Obtener las personas que pertenecen a esta emisora
     */
    public function personas(): HasMany
    {
        return $this->hasMany(Persona::class);
    }

    /**
     * Obtener los teléfonos asignados a personas de esta emisora
     */
    public function telefonos(): HasMany
    {
        return $this->hasManyThrough(Telefono::class, Persona::class);
    }

    /**
     * Obtener las líneas asignadas a personas de esta emisora
     */
    public function lineas(): HasMany
    {
        return $this->hasManyThrough(Linea::class, Persona::class);
    }
}