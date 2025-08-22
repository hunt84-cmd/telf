@extends('layouts.app')

@section('title', 'Almacén de Teléfonos - Sistema de Emisoras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-warehouse me-2"></i>Almacén de Teléfonos
            </h1>
            <div>
                <a href="{{ route('telefonos.index') }}" class="btn btn-info me-2">
                    <i class="fas fa-list me-2"></i>Ver Todas
                </a>
                <a href="{{ route('telefonos.asignados') }}" class="btn btn-success me-2">
                    <i class="fas fa-users me-2"></i>Ver Asignados
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
                    <i class="fas fa-boxes me-2"></i>Teléfonos Disponibles en Almacén
                </h6>
            </div>
            <div class="card-body">
                @if($telefonos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="telefonosAlmacenTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Modelo</th>
                                    <th>Estado Técnico</th>
                                    <th>PIN</th>
                                    <th>PUK</th>
                                    <th>Fecha Ingreso</th>
                                    <th>Observaciones</th>
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
                                    <td>{{ $telefono->pin }}</td>
                                    <td>{{ $telefono->puk }}</td>
                                    <td>{{ $telefono->fecha_ingreso_almacen->format('d/m/Y') }}</td>
                                    <td>
                                        @if($telefono->observaciones)
                                            <span class="text-muted" title="{{ $telefono->observaciones }}">
                                                {{ Str::limit($telefono->observaciones, 30) }}
                                            </span>
                                        @else
                                            <span class="text-muted">Sin observaciones</span>
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
                                            @if($telefono->estado_tecnico === 'Bueno')
                                                <a href="{{ route('telefonos.asignar', $telefono) }}" 
                                                   class="btn btn-sm btn-success" 
                                                   title="Asignar">
                                                    <i class="fas fa-user-plus"></i>
                                                </a>
                                            @endif
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    title="Eliminar"
                                                    onclick="confirmDelete('{{ route('telefonos.destroy', $telefono) }}', '¿Está seguro de que desea eliminar el teléfono {{ $telefono->modelo }}?')">
                                                <i class="fas fa-trash"></i>
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
                        <i class="fas fa-warehouse fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted">Almacén Vacío</h4>
                        <p class="text-muted">No hay teléfonos disponibles en el almacén actualmente.</p>
                        <a href="{{ route('telefonos.create') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i>Ingresar Primer Teléfono
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas del Almacén -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total en Almacén
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $telefonos->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-warehouse fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
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
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $telefonos->where('estado_tecnico', 'Dañado')->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tools fa-2x text-gray-300"></i>
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
                            Disponibles
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $telefonos->where('estado_tecnico', 'Bueno')->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Distribución por Estado Técnico -->
@if($telefonos->count() > 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-pie me-2"></i>Distribución por Estado Técnico
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="h2 text-success">{{ $telefonos->where('estado_tecnico', 'Bueno')->count() }}</div>
                            <div class="text-success">En Buen Estado</div>
                            <small class="text-muted">Disponibles para asignación</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="h2 text-warning">{{ $telefonos->where('estado_tecnico', 'Dañado')->count() }}</div>
                            <div class="text-warning">Necesitan Reparación</div>
                            <small class="text-muted">Requieren mantenimiento</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="h2 text-danger">{{ $telefonos->where('estado_tecnico', 'Roto')->count() }}</div>
                            <div class="text-danger">No Funcionales</div>
                            <small class="text-muted">No pueden ser asignados</small>
                        </div>
                    </div>
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
    $('#telefonosAlmacenTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        pageLength: 20,
        order: [[0, 'desc']],
        responsive: true
    });
});
</script>
@endpush