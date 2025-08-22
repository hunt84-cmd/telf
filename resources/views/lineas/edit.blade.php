@extends('layouts.app')

@section('title', 'Editar ' . $linea->numero_telefono . ' - Sistema de Emisoras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-edit me-2"></i>Editar Línea: {{ $linea->numero_telefono }}
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
                    <i class="fas fa-edit me-2"></i>Editar Información de la Línea
                </h6>
            </div>
            <div class="card-body">
                <form id="lineaForm" method="POST" action="{{ route('lineas.update', $linea) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="numero_telefono" class="form-label">
                                <i class="fas fa-phone me-1"></i>Número de Teléfono <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('numero_telefono') is-invalid @enderror" 
                                   id="numero_telefono" 
                                   name="numero_telefono" 
                                   value="{{ old('numero_telefono', $linea->numero_telefono) }}" 
                                   required 
                                   maxlength="20"
                                   placeholder="Ej: +5351234567">
                            @error('numero_telefono')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="estado" class="form-label">
                                <i class="fas fa-toggle-on me-1"></i>Estado <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('estado') is-invalid @enderror" 
                                    id="estado" 
                                    name="estado" 
                                    required>
                                <option value="">Seleccione el estado</option>
                                @foreach($estados as $estado)
                                    <option value="{{ $estado }}" {{ old('estado', $linea->estado) == $estado ? 'selected' : '' }}>
                                        {{ $estado }}
                                    </option>
                                @endforeach
                            </select>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="pin" class="form-label">
                                <i class="fas fa-key me-1"></i>PIN <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('pin') is-invalid @enderror" 
                                   id="pin" 
                                   name="pin" 
                                   value="{{ old('pin', $linea->pin) }}" 
                                   required 
                                   maxlength="10"
                                   placeholder="Ej: 1234">
                            @error('pin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="puk" class="form-label">
                                <i class="fas fa-lock me-1"></i>PUK <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('puk') is-invalid @enderror" 
                                   id="puk" 
                                   name="puk" 
                                   value="{{ old('puk', $linea->puk) }}" 
                                   required 
                                   maxlength="10"
                                   placeholder="Ej: 12345678">
                            @error('puk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="paquete_id" class="form-label">
                                <i class="fas fa-box me-1"></i>Paquete
                            </label>
                            <select class="form-select @error('paquete_id') is-invalid @enderror" 
                                    id="paquete_id" 
                                    name="paquete_id">
                                <option value="">Sin paquete asignado</option>
                                @foreach($paquetes as $paquete)
                                    <option value="{{ $paquete->id }}" {{ old('paquete_id', $linea->paquete_id) == $paquete->id ? 'selected' : '' }}>
                                        {{ $paquete->nombre }} - {{ $paquete->precio_formateado }}
                                    </option>
                                @endforeach
                            </select>
                            @error('paquete_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="observaciones" class="form-label">
                                <i class="fas fa-align-left me-1"></i>Observaciones
                            </label>
                            <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                      id="observaciones" 
                                      name="observaciones" 
                                      rows="3"
                                      placeholder="Observaciones adicionales sobre la línea (opcional)">{{ old('observaciones', $linea->observaciones) }}</textarea>
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
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Actualizar Línea
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
                    <label class="form-label fw-bold">Número Actual:</label>
                    <p class="mb-0">{{ $linea->numero_telefono }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Estado Actual:</label>
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
                    <label class="form-label fw-bold">PIN Actual:</label>
                    <p class="mb-0">{{ $linea->pin }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">PUK Actual:</label>
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
                    <label class="form-label fw-bold">Estado de Asignación:</label>
                    <p class="mb-0">
                        @if($linea->isEnAlmacen())
                            <span class="badge bg-info">En Almacén</span>
                        @else
                            <span class="badge bg-success">Asignada</span>
                        @endif
                    </p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Observaciones Actuales:</label>
                    <p class="mb-0">{{ $linea->observaciones ?: 'Sin observaciones' }}</p>
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
                        <li>El cambio del número puede afectar las referencias en el sistema</li>
                        <li>Los cambios se aplicarán inmediatamente</li>
                        <li>Si la línea está asignada, los cambios afectarán a la persona</li>
                    </ul>
                </div>
                
                @if($linea->isAsignada())
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle me-2"></i>Información:</h6>
                        <p class="mb-0">Esta línea está asignada a <strong>{{ $linea->persona->nombre_completo }}</strong> de la emisora <strong>{{ $linea->persona->emisora->nombre }}</strong>.</p>
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
    $('#lineaForm').on('submit', function(e) {
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
                    showNotification('Error al actualizar la línea', 'error');
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