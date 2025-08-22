@extends('layouts.app')

@section('title', 'Editar ' . $telefono->modelo . ' - Sistema de Emisoras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-edit me-2"></i>Editar Teléfono: {{ $telefono->modelo }}
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
                    <i class="fas fa-edit me-2"></i>Editar Información del Teléfono
                </h6>
            </div>
            <div class="card-body">
                <form id="telefonoForm" method="POST" action="{{ route('telefonos.update', $telefono) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modelo" class="form-label">
                                <i class="fas fa-mobile-alt me-1"></i>Modelo del Teléfono <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('modelo') is-invalid @enderror" 
                                   id="modelo" 
                                   name="modelo" 
                                   value="{{ old('modelo', $telefono->modelo) }}" 
                                   required 
                                   maxlength="255"
                                   placeholder="Ej: Samsung Galaxy A54, iPhone 14">
                            @error('modelo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="estado_tecnico" class="form-label">
                                <i class="fas fa-tools me-1"></i>Estado Técnico <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('estado_tecnico') is-invalid @enderror" 
                                    id="estado_tecnico" 
                                    name="estado_tecnico" 
                                    required>
                                <option value="">Seleccione el estado</option>
                                @foreach($estadosTecnicos as $estado)
                                    <option value="{{ $estado }}" {{ old('estado_tecnico', $telefono->estado_tecnico) == $estado ? 'selected' : '' }}>
                                        {{ $estado }}
                                    </option>
                                @endforeach
                            </select>
                            @error('estado_tecnico')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="observaciones" class="form-label">
                                <i class="fas fa-align-left me-1"></i>Observaciones
                            </label>
                            <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                      id="observaciones" 
                                      name="observaciones" 
                                      rows="3"
                                      placeholder="Observaciones adicionales sobre el estado del teléfono (opcional)">{{ old('observaciones', $telefono->observaciones) }}</textarea>
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
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Actualizar Teléfono
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>Información Actual
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Modelo Actual:</label>
                    <p class="mb-0">{{ $telefono->modelo }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Estado Técnico Actual:</label>
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
                    <label class="form-label fw-bold">Estado de Asignación:</label>
                    <p class="mb-0">
                        @if($telefono->isEnAlmacen())
                            <span class="badge bg-info">En Almacén</span>
                        @else
                            <span class="badge bg-success">Asignado</span>
                        @endif
                    </p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Fecha de Ingreso:</label>
                    <p class="mb-0">{{ $telefono->fecha_ingreso_almacen->format('d/m/Y H:i') }}</p>
                </div>
                
                @if($telefono->fecha_asignacion)
                <div class="mb-3">
                    <label class="form-label fw-bold">Fecha de Asignación:</label>
                    <p class="mb-0">{{ $telefono->fecha_asignacion->format('d/m/Y H:i') }}</p>
                </div>
                @endif
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Observaciones Actuales:</label>
                    <p class="mb-0">{{ $telefono->observaciones ?: 'Sin observaciones' }}</p>
                </div>
            </div>
        </div>
        
        <div class="card shadow mt-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-exclamation-triangle me-2"></i>Advertencia
                </h6>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Importante:</h6>
                    <ul class="mb-0">
                        <li>El cambio del modelo puede afectar las referencias en el sistema</li>
                        <li>Los cambios se aplicarán inmediatamente</li>
                        <li>Si el teléfono está asignado, los cambios afectarán a la persona</li>
                        <li>El cambio del estado técnico puede afectar la asignabilidad</li>
                    </ul>
                </div>
                
                @if($telefono->isAsignado())
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle me-2"></i>Información:</h6>
                        <p class="mb-0">Este teléfono está asignado a <strong>{{ $telefono->persona->nombre_completo }}</strong> de la emisora <strong>{{ $telefono->persona->emisora->nombre }}</strong>.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#telefonoForm').on('submit', function(e) {
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
                    showNotification('Error al actualizar el teléfono', 'error');
                }
            }
        });
    });
    
    // Limpiar errores al escribir
    $('input, select, textarea').on('input change', function() {
        $(this).removeClass('is-invalid');
    });
    
    // Validar estado técnico
    $('#estado_tecnico').on('change', function() {
        const estado = $(this).val();
        if (estado === 'Roto') {
            showNotification('Advertencia: Los teléfonos rotos no pueden ser asignados a personas.', 'warning');
        }
    });
});
</script>
@endpush