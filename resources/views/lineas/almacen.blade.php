@extends('layouts.app')

@section('title', 'Almacén de Líneas - Sistema de Emisoras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-warehouse me-2"></i>Almacén de Líneas
            </h1>
            <div>
                <a href="{{ route('lineas.index') }}" class="btn btn-info me-2">
                    <i class="fas fa-list me-2"></i>Ver Todas
                </a>
                <a href="{{ route('lineas.asignadas') }}" class="btn btn-success me-2">
                    <i class="fas fa-users me-2"></i>Ver Asignadas
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
                    <i class="fas fa-boxes me-2"></i>Líneas Disponibles en Almacén
                </h6>
            </div>
            <div class="card-body">
                @if($lineas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="lineasAlmacenTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Número</th>
                                    <th>Estado</th>
                                    <th>Paquete</th>
                                    <th>PIN</th>
                                    <th>PUK</th>
                                    <th>Fecha Ingreso</th>
                                    <th>Observaciones</th>
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
                                    <td>{{ $linea->pin }}</td>
                                    <td>{{ $linea->puk }}</td>
                                    <td>{{ $linea->fecha_ingreso_almacen->format('d/m/Y') }}</td>
                                    <td>
                                        @if($linea->observaciones)
                                            <span class="text-muted" title="{{ $linea->observaciones }}">
                                                {{ Str::limit($linea->observaciones, 30) }}
                                            </span>
                                        @else
                                            <span class="text-muted">Sin observaciones</span>
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
                                            @if($linea->estado === 'Activa')
                                                <a href="{{ route('lineas.asignar', $linea) }}" 
                                                   class="btn btn-sm btn-success" 
                                                   title="Asignar">
                                                    <i class="fas fa-user-plus"></i>
                                                </a>
                                            @endif
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    title="Eliminar"
                                                    onclick="confirmDelete('{{ route('lineas.destroy', $linea) }}', '¿Está seguro de que desea eliminar la línea {{ $linea->numero_telefono }}?')">
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
                        {{ $lineas->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-warehouse fa-4x text-muted mb-4"></i>
                        <h4 class="text-muted">Almacén Vacío</h4>
                        <p class="text-muted">No hay líneas disponibles en el almacén actualmente.</p>
                        <a href="{{ route('lineas.create') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i>Ingresar Primera Línea
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
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lineas->count() }}</div>
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
    
    <div class="col-md-3">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
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
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Disponibles
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $lineas->where('estado', 'Activa')->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-plus fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#lineasAlmacenTable').DataTable({
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