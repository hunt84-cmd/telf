<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Emisora;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class PersonaController extends Controller
{
    /**
     * Mostrar lista de personas
     */
    public function index(): View
    {
        $personas = Persona::with(['emisora', 'telefono', 'linea.paquete'])->paginate(10);
        return view('personas.index', compact('personas'));
    }

    /**
     * Mostrar formulario para crear persona
     */
    public function create(): View
    {
        $emisoras = Emisora::all();
        return view('personas.create', compact('emisoras'));
    }

    /**
     * Almacenar nueva persona
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'ci' => 'required|string|max:20|unique:personas',
            'emisora_id' => 'required|exists:emisoras,id',
        ]);

        $persona = Persona::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Persona creada exitosamente',
            'data' => $persona->load('emisora')
        ], 201);
    }

    /**
     * Mostrar persona específica
     */
    public function show(Persona $persona): View
    {
        $persona->load(['emisora', 'telefono', 'linea.paquete']);
        return view('personas.show', compact('persona'));
    }

    /**
     * Mostrar formulario para editar persona
     */
    public function edit(Persona $persona): View
    {
        $emisoras = Emisora::all();
        return view('personas.edit', compact('persona', 'emisoras'));
    }

    /**
     * Actualizar persona
     */
    public function update(Request $request, Persona $persona): JsonResponse
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'ci' => 'required|string|max:20|unique:personas,ci,' . $persona->id,
            'emisora_id' => 'required|exists:emisoras,id',
        ]);

        $persona->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Persona actualizada exitosamente',
            'data' => $persona->load('emisora')
        ]);
    }

    /**
     * Eliminar persona
     */
    public function destroy(Persona $persona): JsonResponse
    {
        $persona->delete();

        return response()->json([
            'success' => true,
            'message' => 'Persona eliminada exitosamente'
        ]);
    }

    /**
     * Obtener personas por emisora
     */
    public function getByEmisora(Emisora $emisora): JsonResponse
    {
        $personas = $emisora->personas()->with(['telefono', 'linea.paquete'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $personas
        ]);
    }

    /**
     * Obtener personas para API
     */
    public function apiIndex(): JsonResponse
    {
        $personas = Persona::with(['emisora', 'telefono', 'linea.paquete'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $personas
        ]);
    }
}