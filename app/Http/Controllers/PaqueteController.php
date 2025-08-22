<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class PaqueteController extends Controller
{
    /**
     * Mostrar lista de paquetes
     */
    public function index(): View
    {
        $paquetes = Paquete::withCount('lineas')->paginate(10);
        return view('paquetes.index', compact('paquetes'));
    }

    /**
     * Mostrar formulario para crear paquete
     */
    public function create(): View
    {
        return view('paquetes.create');
    }

    /**
     * Almacenar nuevo paquete
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:paquetes',
            'cantidad_datos' => 'required|integer|min:0',
            'cantidad_minutos' => 'required|integer|min:0',
            'cantidad_sms' => 'required|integer|min:0',
            'precio_costo' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
        ]);

        $paquete = Paquete::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Paquete creado exitosamente',
            'data' => $paquete
        ], 201);
    }

    /**
     * Mostrar paquete específico
     */
    public function show(Paquete $paquete): View
    {
        $paquete->load(['lineas.persona.emisora']);
        return view('paquetes.show', compact('paquete'));
    }

    /**
     * Mostrar formulario para editar paquete
     */
    public function edit(Paquete $paquete): View
    {
        return view('paquetes.edit', compact('paquete'));
    }

    /**
     * Actualizar paquete
     */
    public function update(Request $request, Paquete $paquete): JsonResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:paquetes,nombre,' . $paquete->id,
            'cantidad_datos' => 'required|integer|min:0',
            'cantidad_minutos' => 'required|integer|min:0',
            'cantidad_sms' => 'required|integer|min:0',
            'precio_costo' => 'required|numeric|min:0',
            'descripcion' => 'nullable|string',
        ]);

        $paquete->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Paquete actualizado exitosamente',
            'data' => $paquete
        ]);
    }

    /**
     * Eliminar paquete
     */
    public function destroy(Paquete $paquete): JsonResponse
    {
        // Verificar si hay líneas usando este paquete
        if ($paquete->lineas()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar el paquete porque está siendo usado por líneas'
            ], 422);
        }

        $paquete->delete();

        return response()->json([
            'success' => true,
            'message' => 'Paquete eliminado exitosamente'
        ]);
    }

    /**
     * Obtener paquetes para API
     */
    public function apiIndex(): JsonResponse
    {
        $paquetes = Paquete::withCount('lineas')->get();
        
        return response()->json([
            'success' => true,
            'data' => $paquetes
        ]);
    }

    /**
     * Obtener paquetes disponibles (sin líneas asignadas)
     */
    public function getDisponibles(): JsonResponse
    {
        $paquetes = Paquete::whereDoesntHave('lineas')->get();
        
        return response()->json([
            'success' => true,
            'data' => $paquetes
        ]);
    }
}