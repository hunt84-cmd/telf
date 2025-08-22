<?php

namespace App\Http\Controllers;

use App\Models\Linea;
use App\Models\Persona;
use App\Models\Paquete;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class LineaController extends Controller
{
    /**
     * Mostrar lista de líneas
     */
    public function index(): View
    {
        $lineas = Linea::with(['persona.emisora', 'paquete'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('lineas.index', compact('lineas'));
    }

    /**
     * Mostrar líneas en almacén
     */
    public function almacen(): View
    {
        $lineas = Linea::whereNull('persona_id')
            ->orderBy('fecha_ingreso_almacen', 'desc')
            ->paginate(15);
        return view('lineas.almacen', compact('lineas'));
    }

    /**
     * Mostrar líneas asignadas
     */
    public function asignadas(): View
    {
        $lineas = Linea::whereNotNull('persona_id')
            ->with(['persona.emisora', 'paquete'])
            ->orderBy('fecha_asignacion', 'desc')
            ->paginate(15);
        return view('lineas.asignadas', compact('lineas'));
    }

    /**
     * Mostrar formulario para crear línea
     */
    public function create(): View
    {
        $estados = Linea::getEstados();
        $paquetes = Paquete::all();
        return view('lineas.create', compact('estados', 'paquetes'));
    }

    /**
     * Almacenar nueva línea
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'numero_telefono' => 'required|string|max:20|unique:lineas',
            'pin' => 'required|string|max:10',
            'puk' => 'required|string|max:10',
            'estado' => 'required|in:' . implode(',', Linea::getEstados()),
            'paquete_id' => 'nullable|exists:paquetes,id',
            'observaciones' => 'nullable|string',
        ]);

        $linea = Linea::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Línea ingresada al almacén exitosamente',
            'data' => $linea->load('paquete')
        ], 201);
    }

    /**
     * Mostrar línea específica
     */
    public function show(Linea $linea): View
    {
        $linea->load(['persona.emisora', 'paquete']);
        return view('lineas.show', compact('linea'));
    }

    /**
     * Mostrar formulario para editar línea
     */
    public function edit(Linea $linea): View
    {
        $estados = Linea::getEstados();
        $paquetes = Paquete::all();
        return view('lineas.edit', compact('linea', 'estados', 'paquetes'));
    }

    /**
     * Actualizar línea
     */
    public function update(Request $request, Linea $linea): JsonResponse
    {
        $request->validate([
            'numero_telefono' => 'required|string|max:20|unique:lineas,numero_telefono,' . $linea->id,
            'pin' => 'required|string|max:10',
            'puk' => 'required|string|max:10',
            'estado' => 'required|in:' . implode(',', Linea::getEstados()),
            'paquete_id' => 'nullable|exists:paquetes,id',
            'observaciones' => 'nullable|string',
        ]);

        $linea->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Línea actualizada exitosamente',
            'data' => $linea->load('paquete')
        ]);
    }

    /**
     * Eliminar línea
     */
    public function destroy(Linea $linea): JsonResponse
    {
        if ($linea->isAsignada()) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar una línea que está asignada'
            ], 422);
        }

        $linea->delete();

        return response()->json([
            'success' => true,
            'message' => 'Línea eliminada exitosamente'
        ]);
    }

    /**
     * Mostrar formulario para asignar línea
     */
    public function asignar(Linea $linea): View
    {
        if ($linea->isAsignada()) {
            abort(400, 'Esta línea ya está asignada');
        }

        $personas = Persona::whereDoesntHave('linea')->with('emisora')->get();
        $paquetes = Paquete::all();
        return view('lineas.asignar', compact('linea', 'personas', 'paquetes'));
    }

    /**
     * Asignar línea a persona
     */
    public function asignarPersona(Request $request, Linea $linea): JsonResponse
    {
        $request->validate([
            'persona_id' => 'required|exists:personas,id',
            'paquete_id' => 'nullable|exists:paquetes,id',
        ]);

        if ($linea->isAsignada()) {
            return response()->json([
                'success' => false,
                'message' => 'Esta línea ya está asignada'
            ], 422);
        }

        $persona = Persona::findOrFail($request->persona_id);
        
        if ($persona->linea) {
            return response()->json([
                'success' => false,
                'message' => 'Esta persona ya tiene una línea asignada'
            ], 422);
        }

        $linea->update([
            'persona_id' => $persona->id,
            'paquete_id' => $request->paquete_id,
            'fecha_asignacion' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Línea asignada exitosamente',
            'data' => $linea->load(['persona.emisora', 'paquete'])
        ]);
    }

    /**
     * Devolver línea al almacén
     */
    public function devolverAlmacen(Linea $linea): JsonResponse
    {
        if ($linea->isEnAlmacen()) {
            return response()->json([
                'success' => false,
                'message' => 'Esta línea ya está en almacén'
            ], 422);
        }

        $linea->update([
            'persona_id' => null,
            'fecha_asignacion' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Línea devuelta al almacén exitosamente',
            'data' => $linea
        ]);
    }

    /**
     * Asignar paquete a línea
     */
    public function asignarPaquete(Request $request, Linea $linea): JsonResponse
    {
        $request->validate([
            'paquete_id' => 'required|exists:paquetes,id',
        ]);

        $linea->update(['paquete_id' => $request->paquete_id]);

        return response()->json([
            'success' => true,
            'message' => 'Paquete asignado a la línea exitosamente',
            'data' => $linea->load('paquete')
        ]);
    }

    /**
     * Quitar paquete de línea
     */
    public function quitarPaquete(Linea $linea): JsonResponse
    {
        $linea->update(['paquete_id' => null]);

        return response()->json([
            'success' => true,
            'message' => 'Paquete removido de la línea exitosamente',
            'data' => $linea
        ]);
    }

    /**
     * Obtener líneas para API
     */
    public function apiIndex(): JsonResponse
    {
        $lineas = Linea::with(['persona.emisora', 'paquete'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $lineas
        ]);
    }

    /**
     * Obtener líneas disponibles en almacén
     */
    public function getDisponibles(): JsonResponse
    {
        $lineas = Linea::whereNull('persona_id')->with('paquete')->get();
        
        return response()->json([
            'success' => true,
            'data' => $lineas
        ]);
    }
}