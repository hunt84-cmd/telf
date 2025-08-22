@extends('layouts.app')

@section('title', 'Asignar Línea ' . $linea->numero_telefono . ' - Sistema de Emisoras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-user-plus me-2"></i>Asignar Línea: {{ $linea->numero_telefono }}
            </h1>
            <a href="{{ route('lineas.show', $linea) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-edit me-2"></i>Asignar Línea a Persona
                </h6>
            </div>
            <div class="card-body">
                <form id="asignarLineaForm" method="POST" action="{{ route('lineas.asignar-persona', $linea) }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="persona_id" class="form-label">
                                <i class="fas fa-user me-1"></i>Seleccionar Persona <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('persona_id') is-invalid @enderror" 
                                    id="persona_id" 
                                    name="persona_id" 
                                    required>
                                <option value="">Seleccione una persona</option>
                                @foreach($personas as $persona)
                                    <option value="{{ $persona->id }}" {{ old('persona_id') == $persona->id ? 'selected' : '' }}>
                                        {{ $persona->nombre_completo }} - {{ $persona->emisora->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('persona_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="paquete_id" class="form-label">
                                <i class="fas fa-box me-1"></i>Paquete (Opcional)
                            </label>
                            <select class="form-select @error('paquete_id') is-invalid @enderror" 
                                    id="paquete_id" 
                                    name="paquete_id">
                                <option value="">Sin paquete asignado</option>
                                @foreach($paquetes as $paquete)
                                    <option value="{{ $paquete->id }}" {{ old('paquete_id') == $paquete->id ? 'selected' : '' }}>
                                        {{ $paquete->nombre }} - {{ $paquete->precio_formateado }}
                                    </option>
                                @endforeach
                            </select>
                            @error('paquete_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="observaciones" class="form-label">
                                <i class="fas fa-align-left me-1"></i>Observaciones de Asignación
                            </label>
                            <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                      id="observaciones" 
                                      name="observaciones" 
                                      rows="3"
                                      placeholder="Observaciones sobre la asignación (opcional)">{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary me-2" onclick="window.location.href='{{ route('lineas.show', $linea) }}'">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-user-plus me-2"></i>Asignar Línea
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Información de la Línea -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>Información de la Línea
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Número:</label>
                    <p class="mb-0">{{ $linea->numero_telefono }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Estado:</label>
                    <p class="mb-0">
                        @if($linea->estado === 'Activa')
                            <span class="badge bg-success">Activa</span>
                        @elseif($linea->estado === 'Inactiva')
                            <span class="badge bg-secondary">Inactiva</span>
                        @else
                            <span class="badge bg-danger">Suspendida</span>
                        @endif
                    </p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">PIN:</label>
                    <p class="mb-0">{{ $linea->pin }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">PUK:</label>
                    <p class="mb-0">{{ $linea->puk }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Paquete Actual:</label>
                    @if($linea->paquete)
                        <p class="mb-0">
                            <span class="badge bg-info">{{ $linea->paquete->nombre }}</span>
                        </p>
                    @else
                        <p class="mb-0">
                            <span class="badge bg-warning">Sin paquete asignado</span>
                        </p>
                    @endif
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Fecha de Ingreso:</label>
                    <p class="mb-0">{{ $linea->fecha_ingreso_almacen->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
        
        <!-- Personas Disponibles -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-users me-2"></i>Personas Disponibles
                </h6>
            </div>
            <div class="card-body">
                @if($personas->count() > 0)
                    <div class="mb-3">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Se muestran solo personas sin línea asignada
                        </small>
                    </div>
                    
                    <div class="list-group">
                        @foreach($personas->take(5) as $persona)
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $persona->nombre_completo }}</h6>
                                    <small class="text-muted">{{ $persona->ci }}</small>
                                </div>
                                <p class="mb-1">
                                    <span class="badge bg-primary">{{ $persona->emisora->nombre }}</span>
                                </p>
                                <small class="text-muted">
                                    Responsable: {{ $persona->emisora->responsable }}
                                </small>
                            </div>
                        @endforeach
                    </div>
                    
                    @if($personas->count() > 5)
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                Y {{ $personas->count() - 5 }} personas más...
                            </small>
                        </div>
                    @endif
                @else
                    <div class="text-center py-3">
                        <i class="fas fa-users fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-0">No hay personas disponibles para asignar</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Verificación de Disponibilidad -->
@if($linea->estado !== 'Activa')
<div class="row mt-4">
    <div class="col-12">
        <div class="alert alert-warning">
            <h6><i class="fas fa-exclamation-triangle me-2"></i>Advertencia:</h6>
            <p class="mb-0">
                Esta línea tiene estado <strong>{{ $linea->estado }}</strong>. 
                Solo las líneas con estado "Activa" pueden ser asignadas a personas.
            </p>
        </div>
    </div>
</div>
@endif

@if($personas->count() == 0)
<div class="row mt-4">
    <div class="col-12">
        <div class="alert alert-info">
            <h6><i class="fas fa-info-circle me-2"></i>Información:</h6>
            <p class="mb-0">
                No hay personas disponibles para asignar esta línea. 
                Todas las personas ya tienen una línea asignada o no hay personas registradas en el sistema.
            </p>
            <div class="mt-3">
                <a href="{{ route('personas.create') }}" class="btn btn-primary me-2">
                    <i class="fas fa-user-plus me-2"></i>Crear Nueva Persona
                </a>
                <a href="{{ route('personas.index') }}" class="btn btn-info">
                    <i class="fas fa-users me-2"></i>Ver Todas las Personas
                </a>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#asignarLineaForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    showNotification(response.message);
                    setTimeout(() => {
                        window.location.href = '{{ route('lineas.show', $linea) }}';
                    }, 1500);
                } else {
                    showNotification(response.message, 'error');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(field => {
                        const input = $(`[name="${field}"]`);
                        input.addClass('is-invalid');
                        input.siblings('.invalid-feedback').text(errors[field][0]);
                    });
                } else {
                    showNotification('Error al asignar la línea', 'error');
                }
            }
        });
    });
    
    // Limpiar errores al escribir
    $('input, select, textarea').on('input change', function() {
        $(this).removeClass('is-invalid');
    });
    
    // Cambiar paquete automáticamente si se selecciona
    $('#paquete_id').on('change', function() {
        if ($(this).val()) {
            showNotification('Paquete seleccionado. Se asignará junto con la línea.', 'info');
        }
    });
});
</script>
@endpush