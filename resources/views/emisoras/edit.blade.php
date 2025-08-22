@extends('layouts.app')

@section('title', 'Editar ' . $emisora->nombre . ' - Sistema de Emisoras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-edit me-2"></i>Editar Emisora: {{ $emisora->nombre }}
            </h1>
            <a href="{{ route('emisoras.show', $emisora) }}" class="btn btn-secondary">
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
                    <i class="fas fa-edit me-2"></i>Editar Información de la Emisora
                </h6>
            </div>
            <div class="card-body">
                <form id="emisoraForm" method="POST" action="{{ route('emisoras.update', $emisora) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label">
                                <i class="fas fa-broadcast-tower me-1"></i>Nombre de la Emisora <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="{{ old('nombre', $emisora->nombre) }}" 
                                   required 
                                   maxlength="255"
                                   placeholder="Ej: Radio Ciudad">
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="responsable" class="form-label">
                                <i class="fas fa-user me-1"></i>Responsable <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('responsable') is-invalid @enderror" 
                                   id="responsable" 
                                   name="responsable" 
                                   value="{{ old('responsable', $emisora->responsable) }}" 
                                   required 
                                   maxlength="255"
                                   placeholder="Ej: Juan Pérez">
                            @error('responsable')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary me-2" onclick="window.location.href='{{ route('emisoras.show', $emisora) }}'">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Actualizar Emisora
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
                    <label class="form-label fw-bold">Nombre Actual:</label>
                    <p class="mb-0">{{ $emisora->nombre }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Responsable Actual:</label>
                    <p class="mb-0">{{ $emisora->responsable }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Fecha de Creación:</label>
                    <p class="mb-0">{{ $emisora->created_at->format('d/m/Y H:i') }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Última Actualización:</label>
                    <p class="mb-0">{{ $emisora->updated_at->format('d/m/Y H:i') }}</p>
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
                        <li>El cambio del nombre puede afectar las referencias en el sistema</li>
                        <li>Se mantendrán todas las personas, teléfonos y líneas asociadas</li>
                        <li>Los cambios se aplicarán inmediatamente</li>
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
    $('#emisoraForm').on('submit', function(e) {
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
                        window.location.href = '{{ route('emisoras.show', $emisora) }}';
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
                    showNotification('Error al actualizar la emisora', 'error');
                }
            }
        });
    });
    
    // Limpiar errores al escribir
    $('input').on('input', function() {
        $(this).removeClass('is-invalid');
    });
});
</script>
@endpush