<?php

namespace App\Http\Controllers;

use App\Models\Emisora;
use App\Models\Persona;
use App\Models\Telefono;
use App\Models\Linea;
use App\Models\Paquete;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard principal
     */
    public function index(): View
    {
        $stats = $this->getStats();
        $recentActivity = $this->getRecentActivity();
        
        return view('dashboard.index', compact('stats', 'recentActivity'));
    }

    /**
     * Obtener estadísticas del sistema
     */
    private function getStats(): array
    {
        return [
            'total_emisoras' => Emisora::count(),
            'total_personas' => Persona::count(),
            'total_telefonos' => Telefono::count(),
            'total_lineas' => Linea::count(),
            'total_paquetes' => Paquete::count(),
            'telefonos_almacen' => Telefono::whereNull('persona_id')->count(),
            'telefonos_asignados' => Telefono::whereNotNull('persona_id')->count(),
            'lineas_almacen' => Linea::whereNull('persona_id')->count(),
            'lineas_asignadas' => Linea::whereNotNull('persona_id')->count(),
            'lineas_con_paquete' => Linea::whereNotNull('paquete_id')->count(),
            'lineas_sin_paquete' => Linea::whereNull('paquete_id')->count(),
        ];
    }

    /**
     * Obtener actividad reciente
     */
    private function getRecentActivity(): array
    {
        $recentTelefonos = Telefono::with(['persona.emisora'])
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        $recentLineas = Linea::with(['persona.emisora', 'paquete'])
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        $recentPersonas = Persona::with('emisora')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return [
            'telefonos' => $recentTelefonos,
            'lineas' => $recentLineas,
            'personas' => $recentPersonas,
        ];
    }

    /**
     * Obtener estadísticas para API
     */
    public function getStats(): JsonResponse
    {
        $stats = $this->getStats();
        
        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Obtener estadísticas por emisora
     */
    public function getStatsByEmisora(): JsonResponse
    {
        $emisoras = Emisora::withCount([
            'personas',
            'telefonos',
            'lineas'
        ])->get();

        $stats = $emisoras->map(function ($emisora) {
            return [
                'id' => $emisora->id,
                'nombre' => $emisora->nombre,
                'responsable' => $emisora->responsable,
                'total_personas' => $emisora->personas_count,
                'total_telefonos' => $emisora->telefonos_count,
                'total_lineas' => $emisora->lineas_count,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Obtener inventario del almacén
     */
    public function getInventarioAlmacen(): JsonResponse
    {
        $telefonos = Telefono::whereNull('persona_id')
            ->orderBy('fecha_ingreso_almacen', 'desc')
            ->get();

        $lineas = Linea::whereNull('persona_id')
            ->with('paquete')
            ->orderBy('fecha_ingreso_almacen', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'telefonos' => $telefonos,
                'lineas' => $lineas,
            ]
        ]);
    }

    /**
     * Obtener asignaciones activas
     */
    public function getAsignacionesActivas(): JsonResponse
    {
        $telefonos = Telefono::whereNotNull('persona_id')
            ->with(['persona.emisora'])
            ->orderBy('fecha_asignacion', 'desc')
            ->get();

        $lineas = Linea::whereNotNull('persona_id')
            ->with(['persona.emisora', 'paquete'])
            ->orderBy('fecha_asignacion', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'telefonos' => $telefonos,
                'lineas' => $lineas,
            ]
        ]);
    }
}