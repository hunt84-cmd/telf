@extends('layouts.app')

@section('title', 'Teléfonos Asignados - Sistema de Emisoras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-users me-2"></i>Teléfonos Asignados
            </h1>
            <div>
                <a href="{{ route('telefonos.index') }}" class="btn btn-info me-2">
                    <i class="fas fa-list me-2"></i>Ver Todas
                </a>
                <a href="{{ route('telefonos.almacen') }}" class="btn btn-warning me-2">
                    <i class="fas fa-warehouse me-2"></i>Ver Almacén
                </a>
                <a href="{{ route('telefonos.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Nuevo Teléfono
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
                    <i class="fas fa-user-check me-2"></i>Teléfonos Asignados a Personas
                </h6>
            </div>
            <div class="card-body">
                @if($telefonos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="telefonosAsignadosTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Modelo</th>
                                    <th>Estado Técnico</th>
                                    <th>Persona Asignada</th>
                                    <th>Emisora</th>
                                    <th>Fecha Asignación</th>
                                    <th>Tiempo Asignado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($telefonos as $telefono)
                                <tr>
                                    <td>{{ $telefono->id }}</td>
                                    <td>
                                        <strong>{{ $telefono->modelo }}</strong>
                                    </td>
                                    <td>
                                        @if($telefono->estado_tecnico === 'Bueno')
                                            <span class="badge bg-success">Bueno</span>
                                        @elseif($telefono->estado_tecnico === 'Dañado')
                                            <span class="badge bg-warning">Dañado</span>
                                        @else
                                            <span class="badge bg-danger">Roto</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-user-circle fa-2x text-primary me-2"></i>
                                            <div>
                                                <strong>{{ $telefono->persona->nombre_completo }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $telefono->persona->ci }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $telefono->persona->emisora->nombre }}</span>
                                        <br>
                                        <small class="text-muted">{{ $telefono->persona->emisora->responsable }}</small>
                                    </td>
                                    <td>{{ $telefono->fecha_asignacion->format('d/m/Y H:i') }}</td>
                                    <td>
                                        @php
                                            $dias = $telefono->fecha_asignacion->diffInDays(now());
                                            $horas = $telefono->fecha_asignacion->diffInHours(now()) % 24;
                                        @endphp
                                        @if($dias > 0)
                                            <span class="badge bg-info">{{ $dias }} día(s)</span>
                                        @else
                                            <span class="badge bg-success">{{ $horas }} hora(s)</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('telefonos.show', $telefono) }}" 
                                               class="btn btn-sm btn-info" 
                                               title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('telefonos.edit', $telefono) }}" 
                                               class="btn btn-sm btn-warning" 
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('personas.show', $telefono->persona) }}" 
                                               class="btn btn-sm btn-primary" 
                                               title="Ver Persona">
                                                <i class="fas fa-user"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-warning" 
                                                    title="Devolver al Almacén"
                                                    onclick="devolverTelefono('{{ route('telefonos.devolver-almacen', $telefono) }}', '{{ $telefono->modelo }}', '{{ $telefono->persona->nombre_completo }}')">
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
                        {{ $telefonos->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted">No Hay Teléfonos Asignados</h4>
                        <p class="text-muted">Actualmente no hay teléfonos asignados a personas.</p>
                        <div class="mt-3">
                            <a href="{{ route('telefonos.almacen') }}" class="btn btn-info me-2">
                                <i class="fas fa-warehouse me-2"></i>Ver Almacén
                            </a>
                            <a href="{{ route('telefonos.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Crear Nuevo Teléfono
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
                            Total Asignados
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $telefonos->count() }}</div>
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
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $telefonos->pluck('persona.emisora.id')->unique()->count() }}</div>
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
                            En Buen Estado
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $telefonos->where('estado_tecnico', 'Bueno')->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                            Necesitan Reparación
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $telefonos->where('estado_tecnico', '!=', 'Bueno')->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tools fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Distribución por Emisora -->
@if($telefonos->count() > 0)
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
                                <th>Teléfonos Asignados</th>
                                <th>En Buen Estado</th>
                                <th>Necesitan Reparación</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($telefonos->groupBy('persona.emisora.id') as $emisoraId => $telefonosEmisora)
                                @php
                                    $emisora = $telefonosEmisora->first()->persona->emisora;
                                    $totalTelefonos = $telefonosEmisora->count();
                                    $enBuenEstado = $telefonosEmisora->where('estado_tecnico', 'Bueno')->count();
                                    $necesitanReparacion = $telefonosEmisora->where('estado_tecnico', '!=', 'Bueno')->count();
                                @endphp
                                <tr>
                                    <td>
                                        <strong>{{ $emisora->nombre }}</strong>
                                    </td>
                                    <td>{{ $emisora->responsable }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $totalTelefonos }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">{{ $enBuenEstado }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning">{{ $necesitanReparacion }}</span>
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
    $('#telefonosAsignadosTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        pageLength: 20,
        order: [[5, 'desc']], // Ordenar por fecha de asignación
        responsive: true
    });
});

function devolverTelefono(url, modelo, persona) {
    if (confirm(`¿Está seguro de que desea devolver el teléfono ${modelo} asignado a ${persona} al almacén?`)) {
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
                showNotification('Error al devolver el teléfono', 'error');
            }
        });
    }
}
</script>
@endpush