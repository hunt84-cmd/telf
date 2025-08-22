@extends('layouts.app')

@section('title', 'Paquetes - Sistema de Emisoras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-box me-2"></i>Paquetes
            </h1>
            <a href="{{ route('paquetes.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nuevo Paquete
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list me-2"></i>Lista de Paquetes
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="paquetesTable">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Datos</th>
                                <th>Minutos</th>
                                <th>SMS</th>
                                <th>Precio</th>
                                <th>Líneas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paquetes as $paquete)
                            <tr>
                                <td>{{ $paquete->id }}</td>
                                <td>
                                    <strong>{{ $paquete->nombre }}</strong>
                                    @if($paquete->descripcion)
                                        <br>
                                        <small class="text-muted">{{ Str::limit($paquete->descripcion, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $paquete->cantidad_datos }} GB</span>
                                </td>
                                <td>
                                    <span class="badge bg-success">{{ $paquete->cantidad_minutos }} min</span>
                                </td>
                                <td>
                                    <span class="badge bg-warning">{{ $paquete->cantidad_sms }} SMS</span>
                                </td>
                                <td>
                                    <strong class="text-primary">{{ $paquete->precio_formateado }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $paquete->lineas_count }}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('paquetes.show', $paquete) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('paquetes.edit', $paquete) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                title="Eliminar"
                                                onclick="confirmDelete('{{ route('paquetes.destroy', $paquete) }}', '¿Está seguro de que desea eliminar el paquete {{ $paquete->nombre }}?')">
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
                    {{ $paquetes->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#paquetesTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
        },
        pageLength: 10,
        order: [[0, 'desc']],
        responsive: true
    });
});
</script>
@endpush