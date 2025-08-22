@extends('layouts.app')

@section('title', 'Emisoras - Sistema de Emisoras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-broadcast-tower me-2"></i>Emisoras
            </h1>
            <a href="{{ route('emisoras.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nueva Emisora
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list me-2"></i>Lista de Emisoras
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="emisorasTable">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Responsable</th>
                                <th>Personas</th>
                                <th>Teléfonos</th>
                                <th>Líneas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($emisoras as $emisora)
                            <tr>
                                <td>{{ $emisora->id }}</td>
                                <td>
                                    <strong>{{ $emisora->nombre }}</strong>
                                </td>
                                <td>{{ $emisora->responsable }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $emisora->personas_count }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-success">{{ $emisora->telefonos_count }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-warning">{{ $emisora->lineas_count }}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('emisoras.show', $emisora) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('emisoras.edit', $emisora) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                title="Eliminar"
                                                onclick="confirmDelete('{{ route('emisoras.destroy', $emisora) }}', '¿Está seguro de que desea eliminar la emisora {{ $emisora->nombre }}?')">
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
                    {{ $emisoras->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#emisorasTable').DataTable({
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