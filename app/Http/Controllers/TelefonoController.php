<?php

namespace App\Http\Controllers;

use App\Models\Telefono;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class TelefonoController extends Controller
{
    /**
     * Mostrar lista de teléfonos
     */
    public function index(): View
    {
        $telefonos = Telefono::with(['persona.emisora'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('telefonos.index', compact('telefonos'));
    }

    /**
     * Mostrar teléfonos en almacén
     */
    public function almacen(): View
    {
        $telefonos = Telefono::whereNull('persona_id')
            ->orderBy('fecha_ingreso_almacen', 'desc')
            ->paginate(15);
        return view('telefonos.almacen', compact('telefonos'));
    }

    /**
     * Mostrar teléfonos asignados
     */
    public function asignados(): View
    {
        $telefonos = Telefono::whereNotNull('persona_id')
            ->with(['persona.emisora'])
            ->orderBy('fecha_asignacion', 'desc')
            ->paginate(15);
        return view('telefonos.asignados', compact('telefonos'));
    }

    /**
     * Mostrar formulario para crear teléfono
     */
    public function create(): View
    {
        $estadosTecnicos = Telefono::getEstadosTecnicos();
        return view('telefonos.create', compact('estadosTecnicos'));
    }

    /**
     * Almacenar nuevo teléfono
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'modelo' => 'required|string|max:255',
            'estado_tecnico' => 'required|in:' . implode(',', Telefono::getEstadosTecnicos()),
            'observaciones' => 'nullable|string',
        ]);

        $telefono = Telefono::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Teléfono ingresado al almacén exitosamente',
            'data' => $telefono
        ], 201);
    }

    /**
     * Mostrar teléfono específico
     */
    public function show(Telefono $telefono): View
    {
        $telefono->load(['persona.emisora']);
        return view('telefonos.show', compact('telefono'));
    }

    /**
     * Mostrar formulario para editar teléfono
     */
    public function edit(Telefono $telefono): View
    {
        $estadosTecnicos = Telefono::getEstadosTecnicos();
        return view('telefonos.edit', compact('telefono', 'estadosTecnicos'));
    }

    /**
     * Actualizar teléfono
     */
    public function update(Request $request, Telefono $telefono): JsonResponse
    {
        $request->validate([
            'modelo' => 'required|string|max:255',
            'estado_tecnico' => 'required|in:' . implode(',', Telefono::getEstadosTecnicos()),
            'observaciones' => 'nullable|string',
        ]);

        $telefono->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Teléfono actualizado exitosamente',
            'data' => $telefono
        ]);
    }

    /**
     * Eliminar teléfono
     */
    public function destroy(Telefono $telefono): JsonResponse
    {
        if ($telefono->isAsignado()) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar un teléfono que está asignado'
            ], 422);
        }

        $telefono->delete();

        return response()->json([
            'success' => true,
            'message' => 'Teléfono eliminado exitosamente'
        ]);
    }

    /**
     * Mostrar formulario para asignar teléfono
     */
    public function asignar(Telefono $telefono): View
    {
        if ($telefono->isAsignado()) {
            abort(400, 'Este teléfono ya está asignado');
        }

        $personas = Persona::whereDoesntHave('telefono')->with('emisora')->get();
        return view('telefonos.asignar', compact('telefono', 'personas'));
    }

    /**
     * Asignar teléfono a persona
     */
    public function asignarPersona(Request $request, Telefono $telefono): JsonResponse
    {
        $request->validate([
            'persona_id' => 'required|exists:personas,id',
        ]);

        if ($telefono->isAsignado()) {
            return response()->json([
                'success' => false,
                'message' => 'Este teléfono ya está asignado'
            ], 422);
        }

        $persona = Persona::findOrFail($request->persona_id);
        
        if ($persona->telefono) {
            return response()->json([
                'success' => false,
                'message' => 'Esta persona ya tiene un teléfono asignado'
            ], 422);
        }

        $telefono->update([
            'persona_id' => $persona->id,
            'fecha_asignacion' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Teléfono asignado exitosamente',
            'data' => $telefono->load('persona.emisora')
        ]);
    }

    /**
     * Devolver teléfono al almacén
     */
    public function devolverAlmacen(Telefono $telefono): JsonResponse
    {
        if ($telefono->isEnAlmacen()) {
            return response()->json([
                'success' => false,
                'message' => 'Este teléfono ya está en almacén'
            ], 422);
        }

        $telefono->update([
            'persona_id' => null,
            'fecha_asignacion' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Teléfono devuelto al almacén exitosamente',
            'data' => $telefono
        ]);
    }

    /**
     * Obtener teléfonos para API
     */
    public function apiIndex(): JsonResponse
    {
        $telefonos = Telefono::with(['persona.emisora'])->get();
        
        return response()->json([
            'success' => true,
            'data' => $telefonos
        ]);
    }

    /**
     * Obtener teléfonos disponibles en almacén
     */
    public function getDisponibles(): JsonResponse
    {
        $telefonos = Telefono::whereNull('persona_id')->get();
        
        return response()->json([
            'success' => true,
            'data' => $telefonos
        ]);
    }
}