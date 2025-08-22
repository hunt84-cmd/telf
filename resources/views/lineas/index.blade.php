@extends('layouts.app')

@section('title', 'Líneas - Sistema de Emisoras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-sim-card me-2"></i>Líneas
            </h1>
            <div>
                <a href="{{ route('lineas.almacen') }}" class="btn btn-info me-2">
                    <i class="fas fa-warehouse me-2"></i>Ver Almacén
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
                    <i class="fas fa-list me-2"></i>Lista de Líneas
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="lineasTable">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Número</th>
                                <th>Estado</th>
                                <th>Estado Asignación</th>
                                <th>Paquete</th>
                                <th>Asignada a</th>
                                <th>Emisora</th>
                                <th>Fecha Ingreso</th>
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
                                    @if($linea->isEnAlmacen())
                                        <span class="badge bg-info">En Almacén</span>
                                    @else
                                        <span class="badge bg-success">Asignada</span>
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
                                    @if($linea->persona)
                                        <span class="badge bg-primary">{{ $linea->persona->nombre_completo }}</span>
                                    @else
                                        <span class="badge bg-secondary">Disponible</span>
                                    @endif
                                </td>
                                <td>
                                    @if($linea->persona)
                                        <span class="badge bg-info">{{ $linea->persona->emisora->nombre }}</span>
                                    @else
                                        <span class="badge bg-secondary">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $linea->fecha_ingreso_almacen->format('d/m/Y') }}
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
                                        @if($linea->isEnAlmacen())
                                            <a href="{{ route('lineas.asignar', $linea) }}" 
                                               class="btn btn-sm btn-success" 
                                               title="Asignar">
                                                <i class="fas fa-user-plus"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    title="Eliminar"
                                                    onclick="confirmDelete('{{ route('lineas.destroy', $linea) }}', '¿Está seguro de que desea eliminar la línea {{ $linea->numero_telefono }}?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @else
                                            <button type="button" 
                                                    class="btn btn-sm btn-warning" 
                                                    title="Devolver al Almacén"
                                                    onclick="devolverLinea('{{ route('lineas.devolver-almacen', $linea) }}', '{{ $linea->numero_telefono }}')">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                        @endif
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
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#lineasTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        pageLength: 15,
        order: [[0, 'desc']],
        responsive: true
    });
});

function devolverLinea(url, numero) {
    if (confirm(`¿Está seguro de que desea devolver la línea ${numero} al almacén?`)) {
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