@extends('layouts.app')

@section('title', 'Líneas Asignadas - Sistema de Emisoras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-users me-2"></i>Líneas Asignadas
            </h1>
            <div>
                <a href="{{ route('lineas.index') }}" class="btn btn-info me-2">
                    <i class="fas fa-list me-2"></i>Ver Todas
                </a>
                <a href="{{ route('lineas.almacen') }}" class="btn btn-warning me-2">
                    <i class="fas fa-warehouse me-2"></i>Ver Almacén
                </a>
                <a href="{{ route('lineas.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Nueva Línea
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-user-check me-2"></i>Líneas Asignadas a Personas
                </h6>
            </div>
            <div class="card-body">
                @if($lineas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="lineasAsignadasTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Número</th>
                                    <th>Estado</th>
                                    <th>Paquete</th>
                                    <th>Persona Asignada</th>
                                    <th>Emisora</th>
                                    <th>Fecha Asignación</th>
                                    <th>Tiempo Asignada</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lineas as $linea)
                                <tr>
                                    <td>{{ $linea->id }}</td>
                                    <td>
                                        <strong>{{ $linea->numero_telefono }}</strong>
                                    </td>
                                    <td>
                                        @if($linea->estado === 'Activa')
                                            <span class="badge bg-success">Activa</span>
                                        @elseif($linea->estado === 'Inactiva')
                                            <span class="badge bg-secondary">Inactiva</span>
                                        @else
                                            <span class="badge bg-danger">Suspendida</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($linea->paquete)
                                            <span class="badge bg-info">{{ $linea->paquete->nombre }}</span>
                                        @else
                                            <span class="badge bg-warning">Sin paquete</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user-circle fa-2x text-primary me-2"></i>
                                            <div>
                                                <strong>{{ $linea->persona->nombre_completo }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $linea->persona->ci }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $linea->persona->emisora->nombre }}</span>
                                        <br>
                                        <small class="text-muted">{{ $linea->persona->emisora->responsable }}</small>
                                    </td>
                                    <td>{{ $linea->fecha_asignacion->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @php
                                            $dias = $linea->fecha_asignacion->diffInDays(now());
                                            $horas = $linea->fecha_asignacion->diffInHours(now()) % 24;
                                        @endphp
                                        @if($dias > 0)
                                            <span class="badge bg-info">{{ $dias }} día(s)</span>
                                        @else
                                            <span class="badge bg-success">{{ $horas }} hora(s)</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('lineas.show', $linea) }}" 
                                               class="btn btn-sm btn-info" 
                                               title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('lineas.edit', $linea) }}" 
                                               class="btn btn-sm btn-warning" 
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('personas.show', $linea->persona) }}" 
                                               class="btn btn-sm btn-primary" 
                                               title="Ver Persona">
                                                <i class="fas fa-user"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-warning" 
                                                    title="Devolver al Almacén"
                                                    onclick="devolverLinea('{{ route('lineas.devolver-almacen', $linea) }}', '{{ $linea->numero_telefono }}', '{{ $linea->persona->nombre_completo }}')">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        {{ $lineas->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted">No Hay Líneas Asignadas</h4>
                        <p class="text-muted">Actualmente no hay líneas asignadas a personas.</p>
                        <div class="mt-3">
                            <a href="{{ route('lineas.almacen') }}" class="btn btn-info me-2">
                                <i class="fas fa-warehouse me-2"></i>Ver Almacén
                            </a>
                            <a href="{{ route('lineas.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Crear Nueva Línea
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas de Asignaciones -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Asignadas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lineas->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Emisoras Activas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lineas->pluck('persona.emisora.id')->unique()->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-broadcast-tower fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Con Paquete
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lineas->whereNotNull('paquete_id')->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Líneas Activas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lineas->where('estado', 'Activa')->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Distribución por Emisora -->
@if($lineas->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-pie me-2"></i>Distribución por Emisora
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Emisora</th>
                                <th>Responsable</th>
                                <th>Líneas Asignadas</th>
                                <th>Con Paquete</th>
                                <th>Líneas Activas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lineas->groupBy('persona.emisora.id') as $emisoraId => $lineasEmisora)
                                @php
                                    $emisora = $lineasEmisora->first()->persona->emisora;
                                    $totalLineas = $lineasEmisora->count();
                                    $conPaquete = $lineasEmisora->whereNotNull('paquete_id')->count();
                                    $activas = $lineasEmisora->where('estado', 'Activa')->count();
                                @endphp
                                <tr>
                                    <td>
                                        <strong>{{ $emisora->nombre }}</strong>
                                    </td>
                                    <td>{{ $emisora->responsable }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $totalLineas }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $conPaquete }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $activas }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('emisoras.show', $emisora) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye me-1"></i>Ver Emisora
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#lineasAsignadasTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        pageLength: 20,
        order: [[6, 'desc']], // Ordenar por fecha de asignación
        responsive: true
    });
});

function devolverLinea(url, numero, persona) {
    if (confirm(`¿Está seguro de que desea devolver la línea ${numero} asignada a ${persona} al almacén?`)) {
        $.ajax({
            url: url,
            type: 'POST',
            success: function(response) {
                if (response.success) {
                    showNotification(response.message);
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showNotification(response.message, 'error');
                }
            },
            error: function() {
                showNotification('Error al devolver la línea', 'error');
            }
        });
    }
}
</script>
@endpush