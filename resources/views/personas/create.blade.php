@extends('layouts.app')

@section('title', 'Nueva Persona - Sistema de Emisoras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-plus me-2"></i>Nueva Persona
            </h1>
            <a href="{{ route('personas.index') }}" class="btn btn-secondary">
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
                    <i class="fas fa-edit me-2"></i>Información de la Persona
                </h6>
            </div>
            <div class="card-body">
                <form id="personaForm" method="POST" action="{{ route('personas.store') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label">
                                <i class="fas fa-user me-1"></i>Nombre <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" 
                                   name="nombre" 
                                   value="{{ old('nombre') }}" 
                                   required 
                                   maxlength="255"
                                   placeholder="Ej: Juan">
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="apellidos" class="form-label">
                                <i class="fas fa-user me-1"></i>Apellidos <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('apellidos') is-invalid @enderror" 
                                   id="apellidos" 
                                   name="apellidos" 
                                   value="{{ old('apellidos') }}" 
                                   required 
                                   maxlength="255"
                                   placeholder="Ej: Pérez García">
                            @error('apellidos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ci" class="form-label">
                                <i class="fas fa-id-card me-1"></i>Cédula de Identidad <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('ci') is-invalid @enderror" 
                                   id="ci" 
                                   name="ci" 
                                   value="{{ old('ci') }}" 
                                   required 
                                   maxlength="20"
                                   placeholder="Ej: 12345678">
                            @error('ci')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="emisora_id" class="form-label">
                                <i class="fas fa-broadcast-tower me-1"></i>Emisora <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('emisora_id') is-invalid @enderror" 
                                    id="emisora_id" 
                                    name="emisora_id" 
                                    required>
                                <option value="">Seleccione una emisora</option>
                                @foreach($emisoras as $emisora)
                                    <option value="{{ $emisora->id }}" {{ old('emisora_id') == $emisora->id ? 'selected' : '' }}>
                                        {{ $emisora->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('emisora_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary me-2" onclick="window.location.href='{{ route('personas.index') }}'">
                                    <i class="fas fa-times me-2"></i>Cancelar
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Guardar Persona
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
                        <li>La CI debe ser única en el sistema</li>
                        <li>Una vez creada, podrás asignarle teléfonos y líneas</li>
                        <li>La persona quedará asociada a la emisora seleccionada</li>
                    </ul>
                </div>
                
                <div class="alert alert-warning">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Importante:</h6>
                    <p class="mb-0">Todos los campos marcados con <span class="text-danger">*</span> son obligatorios.</p>
                </div>
                
                @if($emisoras->count() == 0)
                    <div class="alert alert-danger">
                        <h6><i class="fas fa-exclamation-circle me-2"></i>Advertencia:</h6>
                        <p class="mb-0">No hay emisoras disponibles. Debes crear una emisora antes de registrar personas.</p>
                        <a href="{{ route('emisoras.create') }}" class="btn btn-sm btn-primary mt-2">
                            <i class="fas fa-plus me-1"></i>Crear Emisora
                        </a>
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
    $('#personaForm').on('submit', function(e) {
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
                        window.location.href = '{{ route('personas.index') }}';
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
                    showNotification('Error al crear la persona', 'error');
                }
            }
        });
    });
    
    // Limpiar errores al escribir
    $('input, select').on('input change', function() {
        $(this).removeClass('is-invalid');
    });
});
</script>
@endpush