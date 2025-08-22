@extends('layouts.app')

@section('title', 'Personas - Sistema de Emisoras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-users me-2"></i>Personas
            </h1>
            <a href="{{ route('personas.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Nueva Persona
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-list me-2"></i>Lista de Personas
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="personasTable">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nombre Completo</th>
                                <th>CI</th>
                                <th>Emisora</th>
                                <th>Teléfono</th>
                                <th>Línea</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($personas as $persona)
                            <tr>
                                <td>{{ $persona->id }}</td>
                                <td>
                                    <strong>{{ $persona->nombre_completo }}</strong>
                                </td>
                                <td>{{ $persona->ci }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $persona->emisora->nombre }}</span>
                                </td>
                                <td>
                                    @if($persona->telefono)
                                        <span class="badge bg-success">
                                            <i class="fas fa-mobile-alt me-1"></i>{{ $persona->telefono->modelo }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">Sin asignar</span>
                                    @endif
                                </td>
                                <td>
                                    @if($persona->linea)
                                        <span class="badge bg-info">
                                            <i class="fas fa-sim-card me-1"></i>{{ $persona->linea->numero_telefono }}
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">Sin asignar</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('personas.show', $persona) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('personas.edit', $persona) }}" 
                                           class="btn btn-sm btn-warning" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                title="Eliminar"
                                                onclick="confirmDelete('{{ route('personas.destroy', $persona) }}', '¿Está seguro de que desea eliminar a {{ $persona->nombre_completo }}?')">
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
                    {{ $personas->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#personasTable').DataTable({
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