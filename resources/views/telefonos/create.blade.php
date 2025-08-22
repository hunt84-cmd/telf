@extends('layouts.app')

@section('title', 'Nuevo Teléfono - Sistema de Emisoras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-plus me-2"></i>Nuevo Teléfono
            </h1>
            <a href="{{ route('telefonos.index') }}" class="btn btn-secondary">
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
                    <i class="fas fa-edit me-2"></i>Información del Teléfono
                </h6>
            </div>
            <div class="card-body">
                <form id="telefonoForm" method="POST" action="{{ route('telefonos.store') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modelo" class="form-label">
                                <i class="fas fa-mobile-alt me-1"></i>Modelo del Teléfono <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('modelo') is-invalid @enderror" 
                                   id="modelo" 
                                   name="modelo" 
                                   value="{{ old('modelo') }}" 
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
                                    <option value="{{ $estado }}" {{ old('estado_tecnico') == $estado ? 'selected' : '' }}>
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
                                      placeholder="Observaciones adicionales sobre el estado del teléfono (opcional)">{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary me-2" onclick="window.location.href='{{ route('telefonos.index') }}'">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Guardar Teléfono
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
                    <i class="fas fa-info-circle me-2"></i>Información
                </h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-lightbulb me-2"></i>Consejos:</h6>
                    <ul class="mb-0">
                        <li>El teléfono se ingresará automáticamente al almacén</li>
                        <li>Una vez guardado, podrás asignarlo a una persona</li>
                        <li>El estado técnico determina si el teléfono está en condiciones de uso</li>
                        <li>Las observaciones ayudan a identificar detalles importantes</li>
                    </ul>
                </div>
                
                <div class="alert alert-warning">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Importante:</h6>
                    <p class="mb-0">Todos los campos marcados con <span class="text-danger">*</span> son obligatorios.</p>
                </div>
                
                <div class="alert alert-success">
                    <h6><i class="fas fa-check-circle me-2"></i>Estados Técnicos:</h6>
                    <ul class="mb-0">
                        <li><strong>Bueno:</strong> Teléfono en perfectas condiciones</li>
                        <li><strong>Dañado:</strong> Teléfono con algún problema reparable</li>
                        <li><strong>Roto:</strong> Teléfono con daños irreparables</li>
                    </ul>
                </div>
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
                        window.location.href = '{{ route('telefonos.index') }}';
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
                    showNotification('Error al crear el teléfono', 'error');
                }
            }
        });
    });
    
    // Limpiar errores al escribir
    $('input, select, textarea').on('input change', function() {
        $(this).removeClass('is-invalid');
    });
});
</script>
@endpush