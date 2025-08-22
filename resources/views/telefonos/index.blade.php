@extends('layouts.app')

@section('title', 'Teléfonos - Sistema de Emisoras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-mobile-alt me-2"></i>Teléfonos
            </h1>
            <div>
                <a href="{{ route('telefonos.almacen') }}" class="btn btn-info me-2">
                    <i class="fas fa-warehouse me-2"></i>Ver Almacén
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
                    <i class="fas fa-list me-2"></i>Lista de Teléfonos
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="telefonosTable">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Modelo</th>
                                <th>Estado Técnico</th>
                                <th>Estado Asignación</th>
                                <th>Asignado a</th>
                                <th>Emisora</th>
                                <th>Fecha Ingreso</th>
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
                                    @if($telefono->isEnAlmacen())
                                        <span class="badge bg-info">En Almacén</span>
                                    @else
                                        <span class="badge bg-success">Asignado</span>
                                    @endif
                                </td>
                                <td>
                                    @if($telefono->persona)
                                        <span class="badge bg-primary">{{ $telefono->persona->nombre_completo }}</span>
                                    @else
                                        <span class="badge bg-secondary">Disponible</span>
                                    @endif
                                </td>
                                <td>
                                    @if($telefono->persona)
                                        <span class="badge bg-info">{{ $telefono->persona->emisora->nombre }}</span>
                                    @else
                                        <span class="badge bg-secondary">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $telefono->fecha_ingreso_almacen->format('d/m/Y') }}
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
                                        @if($telefono->isEnAlmacen())
                                            <a href="{{ route('telefonos.asignar', $telefono) }}" 
                                               class="btn btn-sm btn-success" 
                                               title="Asignar">
                                                <i class="fas fa-user-plus"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    title="Eliminar"
                                                    onclick="confirmDelete('{{ route('telefonos.destroy', $telefono) }}', '¿Está seguro de que desea eliminar el teléfono {{ $telefono->modelo }}?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @else
                                            <button type="button" 
                                                    class="btn btn-sm btn-warning" 
                                                    title="Devolver al Almacén"
                                                    onclick="devolverTelefono('{{ route('telefonos.devolver-almacen', $telefono) }}', '{{ $telefono->modelo }}')">
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
                    {{ $telefonos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#telefonosTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        pageLength: 15,
        order: [[0, 'desc']],
        responsive: true
    });
});

function devolverTelefono(url, modelo) {
    if (confirm(`¿Está seguro de que desea devolver el teléfono ${modelo} al almacén?`)) {
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