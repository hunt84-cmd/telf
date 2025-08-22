<?php

namespace App\Http\Controllers;

use App\Models\Emisora;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class EmisoraController extends Controller
{
    /**
     * Mostrar lista de emisoras
     */
    public function index(): View
    {
        $emisoras = Emisora::withCount(['personas', 'telefonos', 'lineas'])->paginate(10);
        return view('emisoras.index', compact('emisoras'));
    }

    /**
     * Mostrar formulario para crear emisora
     */
    public function create(): View
    {
        return view('emisoras.create');
    }

    /**
     * Almacenar nueva emisora
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:emisoras',
            'responsable' => 'required|string|max:255',
        ]);

        $emisora = Emisora::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Emisora creada exitosamente',
            'data' => $emisora
        ], 201);
    }

    /**
     * Mostrar emisora específica
     */
    public function show(Emisora $emisora): View
    {
        $emisora->load(['personas.telefono', 'personas.linea.paquete']);
        return view('emisoras.show', compact('emisora'));
    }

    /**
     * Mostrar formulario para editar emisora
     */
    public function edit(Emisora $emisora): View
    {
        return view('emisoras.edit', compact('emisora'));
    }

    /**
     * Actualizar emisora
     */
    public function update(Request $request, Emisora $emisora): JsonResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:emisoras,nombre,' . $emisora->id,
            'responsable' => 'required|string|max:255',
        ]);

        $emisora->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Emisora actualizada exitosamente',
            'data' => $emisora
        ]);
    }

    /**
     * Eliminar emisora
     */
    public function destroy(Emisora $emisora): JsonResponse
    {
        $emisora->delete();

        return response()->json([
            'success' => true,
            'message' => 'Emisora eliminada exitosamente'
        ]);
    }

    /**
     * Obtener emisoras para API
     */
    public function apiIndex(): JsonResponse
    {
        $emisoras = Emisora::withCount(['personas', 'telefonos', 'lineas'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $emisoras
        ]);
    }
}