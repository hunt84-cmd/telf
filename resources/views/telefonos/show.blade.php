@extends('layouts.app')

@section('title', $telefono->modelo . ' - Sistema de Emisoras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-mobile-alt me-2"></i>{{ $telefono->modelo }}
            </h1>
            <div>
                @if($telefono->isEnAlmacen())
                    <a href="{{ route('telefonos.asignar', $telefono) }}" class="btn btn-success me-2">
                        <i class="fas fa-user-plus me-2"></i>Asignar
                    </a>
                @else
                    <button type="button" class="btn btn-warning me-2" onclick="devolverTelefono()">
                        <i class="fas fa-undo me-2"></i>Devolver al Almacén
                    </button>
                @endif
                <a href="{{ route('telefonos.edit', $telefono) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-2"></i>Editar
                </a>
                <a href="{{ route('telefonos.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Información del Teléfono -->
    <div class="col-lg-4">
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
                    <label class="form-label fw-bold">Fecha de Ingreso al Almacén:</label>
                    <p class="mb-0">{{ $telefono->fecha_ingreso_almacen->format('d/m/Y H:i') }}</p>
                </div>
                
                @if($telefono->fecha_asignacion)
                <div class="mb-3">
                    <label class="form-label fw-bold">Fecha de Asignación:</label>
                    <p class="mb-0">{{ $telefono->fecha_asignacion->format('d/m/Y H:i') }}</p>
                </div>
                @endif
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Observaciones:</label>
                    <p class="mb-0">{{ $telefono->observaciones ?: 'Sin observaciones' }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Fecha de Creación:</label>
                    <p class="mb-0">{{ $telefono->created_at->format('d/m/Y H:i') }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Última Actualización:</label>
                    <p class="mb-0">{{ $telefono->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
        
        <!-- Estado del Teléfono -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-bar me-2"></i>Estado del Teléfono
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    @if($telefono->estado_tecnico === 'Bueno')
                        <div class="border rounded p-4 mb-3 bg-success bg-opacity-10">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h5 class="text-success">En Buenas Condiciones</h5>
                            <p class="text-muted mb-0">Este teléfono está en perfectas condiciones para ser asignado</p>
                        </div>
                    @elseif($telefono->estado_tecnico === 'Dañado')
                        <div class="border rounded p-4 mb-3 bg-warning bg-opacity-10">
                            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                            <h5 class="text-warning">Necesita Reparación</h5>
                            <p class="text-muted mb-0">Este teléfono tiene problemas que pueden ser reparados</p>
                        </div>
                    @else
                        <div class="border rounded p-4 mb-3 bg-danger bg-opacity-10">
                            <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                            <h5 class="text-danger">No Funcional</h5>
                            <p class="text-muted mb-0">Este teléfono no funciona y no puede ser asignado</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Información de Asignación -->
    <div class="col-lg-8">
        @if($telefono->isAsignado())
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user me-2"></i>Persona Asignada
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nombre Completo:</label>
                                <p class="mb-0">
                                    <strong>{{ $telefono->persona->nombre_completo }}</strong>
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Cédula de Identidad:</label>
                                <p class="mb-0">{{ $telefono->persona->ci }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Emisora:</label>
                                <p class="mb-0">
                                    <span class="badge bg-primary">{{ $telefono->persona->emisora->nombre }}</span>
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Responsable de Emisora:</label>
                                <p class="mb-0">{{ $telefono->persona->emisora->responsable }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Fecha de Asignación:</label>
                                <p class="mb-0">{{ $telefono->fecha_asignacion->format('d/m/Y H:i') }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tiempo Asignado:</label>
                                <p class="mb-0">
                                    @php
                                        $dias = $telefono->fecha_asignacion->diffInDays(now());
                                        $horas = $telefono->fecha_asignacion->diffInHours(now()) % 24;
                                    @endphp
                                    {{ $dias }} día(s) y {{ $horas }} hora(s)
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Línea Asignada:</label>
                                @if($telefono->persona->linea)
                                    <p class="mb-0">
                                        <span class="badge bg-info">{{ $telefono->persona->linea->numero_telefono }}</span>
                                    </p>
                                @else
                                    <p class="mb-0">
                                        <span class="badge bg-secondary">Sin línea asignada</span>
                                    </p>
                                @endif
                            </div>
                            
                            <div class="mt-4">
                                <a href="{{ route('personas.show', $telefono->persona) }}" class="btn btn-info me-2">
                                    <i class="fas fa-user me-1"></i>Ver Persona
                                </a>
                                @if($telefono->persona->linea)
                                    <a href="{{ route('lineas.show', $telefono->persona->linea) }}" class="btn btn-success">
                                        <i class="fas fa-sim-card me-1"></i>Ver Línea
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-warehouse me-2"></i>Teléfono en Almacén
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center py-4">
                        <i class="fas fa-warehouse fa-3x text-info mb-3"></i>
                        <h5 class="text-info">Disponible para Asignación</h5>
                        <p class="text-muted">Este teléfono está disponible en el almacén y puede ser asignado a una persona.</p>
                        
                        @if($telefono->estado_tecnico === 'Bueno')
                            <a href="{{ route('telefonos.asignar', $telefono) }}" class="btn btn-success btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Asignar Teléfono
                            </a>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Este teléfono no puede ser asignado debido a su estado técnico: <strong>{{ $telefono->estado_tecnico }}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
        
        <!-- Historial de Cambios -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-history me-2"></i>Historial de Cambios
                </h6>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary">
                            <i class="fas fa-plus"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Teléfono Ingresado al Almacén</h6>
                            <p class="text-muted mb-0">{{ $telefono->fecha_ingreso_almacen->format('d/m/Y H:i') }}</p>
                            <small class="text-muted">Estado: {{ $telefono->estado_tecnico }}</small>
                        </div>
                    </div>
                    
                    @if($telefono->fecha_asignacion)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Asignado a {{ $telefono->persona->nombre_completo }}</h6>
                                <p class="text-muted mb-0">{{ $telefono->fecha_asignacion->format('d/m/Y H:i') }}</p>
                                <small class="text-muted">Emisora: {{ $telefono->persona->emisora->nombre }}</small>
                            </div>
                        </div>
                    @endif
                    
                    <div class="timeline-item">
                        <div class="timeline-marker bg-info">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Última Actualización</h6>
                            <p class="text-muted mb-0">{{ $telefono->updated_at->format('d/m/Y H:i') }}</p>
                            <small class="text-muted">Estado actual: {{ $telefono->estado_tecnico }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-marker {
    position: absolute;
    left: -45px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    border-left: 3px solid #007bff;
}

.timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: -30px;
    top: 30px;
    width: 2px;
    height: calc(100% + 15px);
    background: #dee2e6;
}
</style>
@endpush

@push('scripts')
<script>
function devolverTelefono() {
    if (confirm('¿Está seguro de que desea devolver este teléfono al almacén?')) {
        $.ajax({
            url: '{{ route('telefonos.devolver-almacen', $telefono) }}',
            type: 'POST',
            success: function(response) {
                if (response.success) {
                    showNotification(response.message);
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showNotification(response.message, 'error');
                }
            },
            error: function() {
                showNotification('Error al devolver el teléfono', 'error');
            }
        });
    }
}
</script>
@endpush