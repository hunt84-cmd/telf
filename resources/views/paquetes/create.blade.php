@extends('layouts.app')

@section('title', 'Nuevo Paquete - Sistema de Emisoras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-plus me-2"></i>Nuevo Paquete
            </h1>
            <a href="{{ route('paquetes.index') }}" class="btn btn-secondary">
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
                    <i class="fas fa-edit me-2"></i>Información del Paquete
                </h6>
            </div>
            <div class="card-body">
                <form id="paqueteForm" method="POST" action="{{ route('paquetes.store') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label">
                                <i class="fas fa-box me-1"></i>Nombre del Paquete <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="{{ old('nombre') }}" 
                                   required 
                                   maxlength="255"
                                   placeholder="Ej: Básico, Estándar, Premium">
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="precio_costo" class="form-label">
                                <i class="fas fa-dollar-sign me-1"></i>Precio de Costo <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" 
                                       class="form-control @error('precio_costo') is-invalid @enderror" 
                                       id="precio_costo" 
                                       name="precio_costo" 
                                       value="{{ old('precio_costo') }}" 
                                       required 
                                       step="0.01" 
                                       min="0"
                                       placeholder="0.00">
                            </div>
                            @error('precio_costo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="cantidad_datos" class="form-label">
                                <i class="fas fa-database me-1"></i>Cantidad de Datos (GB) <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('cantidad_datos') is-invalid @enderror" 
                                   id="cantidad_datos" 
                                   name="cantidad_datos" 
                                   value="{{ old('cantidad_datos') }}" 
                                   required 
                                   min="0"
                                   placeholder="Ej: 2, 5, 10">
                            @error('cantidad_datos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="cantidad_minutos" class="form-label">
                                <i class="fas fa-clock me-1"></i>Cantidad de Minutos <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('cantidad_minutos') is-invalid @enderror" 
                                   id="cantidad_minutos" 
                                   name="cantidad_minutos" 
                                   value="{{ old('cantidad_minutos') }}" 
                                   required 
                                   min="0"
                                   placeholder="Ej: 100, 300, 600">
                            @error('cantidad_minutos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="cantidad_sms" class="form-label">
                                <i class="fas fa-comment me-1"></i>Cantidad de SMS <span class="text-danger">*</span>
                            </label>
                            <input type="number" 
                                   class="form-control @error('cantidad_sms') is-invalid @enderror" 
                                   id="cantidad_sms" 
                                   name="cantidad_sms" 
                                   value="{{ old('cantidad_sms') }}" 
                                   required 
                                   min="0"
                                   placeholder="Ej: 50, 150, 300">
                            @error('cantidad_sms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="descripcion" class="form-label">
                                <i class="fas fa-align-left me-1"></i>Descripción
                            </label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                      id="descripcion" 
                                      name="descripcion" 
                                      rows="3"
                                      placeholder="Descripción detallada del paquete (opcional)">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary me-2" onclick="window.location.href='{{ route('paquetes.index') }}'">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Guardar Paquete
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
                        <li>El nombre debe ser único en el sistema</li>
                        <li>Los datos se miden en Gigabytes (GB)</li>
                        <li>Los minutos son para llamadas</li>
                        <li>Los SMS son para mensajes de texto</li>
                        <li>El precio debe incluir decimales si es necesario</li>
                    </ul>
                </div>
                
                <div class="alert alert-warning">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Importante:</h6>
                    <p class="mb-0">Todos los campos marcados con <span class="text-danger">*</span> son obligatorios.</p>
                </div>
                
                <div class="alert alert-success">
                    <h6><i class="fas fa-check-circle me-2"></i>Ejemplos de Paquetes:</h6>
                    <ul class="mb-0">
                        <li><strong>Básico:</strong> 2GB, 100 min, 50 SMS</li>
                        <li><strong>Estándar:</strong> 5GB, 300 min, 150 SMS</li>
                        <li><strong>Premium:</strong> 10GB, 600 min, 300 SMS</li>
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
    $('#paqueteForm').on('submit', function(e) {
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
                        window.location.href = '{{ route('paquetes.index') }}';
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
                    showNotification('Error al crear el paquete', 'error');
                }
            }
        });
    });
    
    // Limpiar errores al escribir
    $('input, textarea').on('input', function() {
        $(this).removeClass('is-invalid');
    });
    
    // Formatear precio automáticamente
    $('#precio_costo').on('blur', function() {
        const value = parseFloat($(this).val());
        if (!isNaN(value)) {
            $(this).val(value.toFixed(2));
        }
    });
});
</script>
@endpush