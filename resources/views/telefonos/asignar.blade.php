@extends('layouts.app')

@section('title', 'Asignar Teléfono ' . $telefono->modelo . ' - Sistema de Emisoras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-user-plus me-2"></i>Asignar Teléfono: {{ $telefono->modelo }}
            </h1>
            <a href="{{ route('telefonos.show', $telefono) }}" class="btn btn-secondary">
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
                    <i class="fas fa-edit me-2"></i>Asignar Teléfono a Persona
                </h6>
            </div>
            <div class="card-body">
                <form id="asignarTelefonoForm" method="POST" action="{{ route('telefonos.asignar-persona', $telefono) }}">
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
                                <button type="button" class="btn btn-secondary me-2" onclick="window.location.href='{{ route('telefonos.show', $telefono) }}'">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-user-plus me-2"></i>Asignar Teléfono
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Información del Teléfono -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>Información del Teléfono
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Modelo:</label>
                    <p class="mb-0">{{ $telefono->modelo }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Estado Técnico:</label>
                    <p class="mb-0">
                        @if($telefono->estado_tecnico === 'Bueno')
                            <span class="badge bg-success">Bueno</span>
                        @elseif($telefono->estado_tecnico === 'Dañado')
                            <span class="badge bg-warning">Dañado</span>
                        @else
                            <span class="badge bg-danger">Roto</span>
                        @endif
                    </p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">PIN:</label>
                    <p class="mb-0">{{ $telefono->pin }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">PUK:</label>
                    <p class="mb-0">{{ $telefono->puk }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Fecha de Ingreso:</label>
                    <p class="mb-0">{{ $telefono->fecha_ingreso_almacen->format('d/m/Y H:i') }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Observaciones:</label>
                    <p class="mb-0">{{ $telefono->observaciones ?: 'Sin observaciones' }}</p>
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
                            Se muestran solo personas sin teléfono asignado
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
@if($telefono->estado_tecnico !== 'Bueno')
<div class="row mt-4">
    <div class="col-12">
        <div class="alert alert-warning">
            <h6><i class="fas fa-exclamation-triangle me-2"></i>Advertencia:</h6>
            <p class="mb-0">
                Este teléfono tiene estado técnico <strong>{{ $telefono->estado_tecnico }}</strong>. 
                Solo los teléfonos con estado técnico "Bueno" pueden ser asignados a personas.
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
                No hay personas disponibles para asignar este teléfono. 
                Todas las personas ya tienen un teléfono asignado o no hay personas registradas en el sistema.
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
    $('#asignarTelefonoForm').on('submit', function(e) {
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
                        window.location.href = '{{ route('telefonos.show', $telefono) }}';
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
                    showNotification('Error al asignar el teléfono', 'error');
                }
            }
        });
    });
    
    // Limpiar errores al escribir
    $('input, select, textarea').on('input change', function() {
        $(this).removeClass('is-invalid');
    });
    
    // Validar selección de persona
    $('#persona_id').on('change', function() {
        if ($(this).val()) {
            const selectedOption = $(this).find('option:selected');
            const personaInfo = selectedOption.text();
            showNotification(`Persona seleccionada: ${personaInfo}`, 'info');
        }
    });
});
</script>
@endpush