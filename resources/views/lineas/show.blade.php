@extends('layouts.app')

@section('title', $linea->numero_telefono . ' - Sistema de Emisoras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-sim-card me-2"></i>{{ $linea->numero_telefono }}
            </h1>
            <div>
                @if($linea->isEnAlmacen())
                    <a href="{{ route('lineas.asignar', $linea) }}" class="btn btn-success me-2">
                        <i class="fas fa-user-plus me-2"></i>Asignar
                    </a>
                @else
                    <button type="button" class="btn btn-warning me-2" onclick="devolverLinea()">
                        <i class="fas fa-undo me-2"></i>Devolver al Almacén
                    </button>
                @endif
                <a href="{{ route('lineas.edit', $linea) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-2"></i>Editar
                </a>
                <a href="{{ route('lineas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Información de la Línea -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>Información de la Línea
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Número de Teléfono:</label>
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
                    <label class="form-label fw-bold">PIN:</label>
                    <p class="mb-0">{{ $linea->pin }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">PUK:</label>
                    <p class="mb-0">{{ $linea->puk }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Fecha de Ingreso al Almacén:</label>
                    <p class="mb-0">{{ $linea->fecha_ingreso_almacen->format('d/m/Y H:i') }}</p>
                </div>
                
                @if($linea->fecha_asignacion)
                <div class="mb-3">
                    <label class="form-label fw-bold">Fecha de Asignación:</label>
                    <p class="mb-0">{{ $linea->fecha_asignacion->format('d/m/Y H:i') }}</p>
                </div>
                @endif
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Observaciones:</label>
                    <p class="mb-0">{{ $linea->observaciones ?: 'Sin observaciones' }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Fecha de Creación:</label>
                    <p class="mb-0">{{ $linea->created_at->format('d/m/Y H:i') }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Última Actualización:</label>
                    <p class="mb-0">{{ $linea->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
        
        <!-- Estado de la Línea -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-bar me-2"></i>Estado de la Línea
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    @if($linea->estado === 'Activa')
                        <div class="border rounded p-4 mb-3 bg-success bg-opacity-10">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h5 class="text-success">Línea Activa</h5>
                            <p class="text-muted mb-0">Esta línea está funcionando normalmente</p>
                        </div>
                    @elseif($linea->estado === 'Inactiva')
                        <div class="border rounded p-4 mb-3 bg-secondary bg-opacity-10">
                            <i class="fas fa-pause-circle fa-3x text-secondary mb-3"></i>
                            <h5 class="text-secondary">Línea Inactiva</h5>
                            <p class="text-muted mb-0">Esta línea no está activada</p>
                        </div>
                    @else
                        <div class="border rounded p-4 mb-3 bg-danger bg-opacity-10">
                            <i class="fas fa-ban fa-3x text-danger mb-3"></i>
                            <h5 class="text-danger">Línea Suspendida</h5>
                            <p class="text-muted mb-0">Esta línea está temporalmente bloqueada</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Gestión de Paquete -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-box me-2"></i>Gestión de Paquete
                </h6>
            </div>
            <div class="card-body">
                @if($linea->hasPaquete())
                    <div class="text-center mb-3">
                        <span class="badge bg-info fs-6">{{ $linea->paquete->nombre }}</span>
                        <p class="text-muted mt-2">{{ $linea->paquete->descripcion_completa }}</p>
                        <p class="text-primary fw-bold">{{ $linea->paquete->precio_formateado }}</p>
                    </div>
                    <button type="button" class="btn btn-warning w-100" onclick="quitarPaquete()">
                        <i class="fas fa-times me-2"></i>Quitar Paquete
                    </button>
                @else
                    <div class="text-center mb-3">
                        <i class="fas fa-box-open fa-2x text-muted mb-2"></i>
                        <p class="text-muted">Sin paquete asignado</p>
                    </div>
                    <button type="button" class="btn btn-primary w-100" onclick="asignarPaquete()">
                        <i class="fas fa-plus me-2"></i>Asignar Paquete
                    </button>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Información de Asignación -->
    <div class="col-lg-8">
        @if($linea->isAsignada())
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
                                    <strong>{{ $linea->persona->nombre_completo }}</strong>
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Cédula de Identidad:</label>
                                <p class="mb-0">{{ $linea->persona->ci }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Emisora:</label>
                                <p class="mb-0">
                                    <span class="badge bg-primary">{{ $linea->persona->emisora->nombre }}</span>
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Responsable de Emisora:</label>
                                <p class="mb-0">{{ $linea->persona->emisora->responsable }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Fecha de Asignación:</label>
                                <p class="mb-0">{{ $linea->fecha_asignacion->format('d/m/Y H:i') }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tiempo Asignada:</label>
                                <p class="mb-0">
                                    @php
                                        $dias = $linea->fecha_asignacion->diffInDays(now());
                                        $horas = $linea->fecha_asignacion->diffInHours(now()) % 24;
                                    @endphp
                                    {{ $dias }} día(s) y {{ $horas }} hora(s)
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Teléfono Asignado:</label>
                                @if($linea->persona->telefono)
                                    <p class="mb-0">
                                        <span class="badge bg-success">{{ $linea->persona->telefono->modelo }}</span>
                                    </p>
                                @else
                                    <p class="mb-0">
                                        <span class="badge bg-secondary">Sin teléfono asignado</span>
                                    </p>
                                @endif
                            </div>
                            
                            <div class="mt-4">
                                <a href="{{ route('personas.show', $linea->persona) }}" class="btn btn-info me-2">
                                    <i class="fas fa-user me-1"></i>Ver Persona
                                </a>
                                @if($linea->persona->telefono)
                                    <a href="{{ route('telefonos.show', $linea->persona->telefono) }}" class="btn btn-success">
                                        <i class="fas fa-mobile-alt me-1"></i>Ver Teléfono
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
                        <i class="fas fa-warehouse me-2"></i>Línea en Almacén
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center py-4">
                        <i class="fas fa-warehouse fa-3x text-info mb-3"></i>
                        <h5 class="text-info">Disponible para Asignación</h5>
                        <p class="text-muted">Esta línea está disponible en el almacén y puede ser asignada a una persona.</p>
                        
                        @if($linea->estado === 'Activa')
                            <a href="{{ route('lineas.asignar', $linea) }}" class="btn btn-success btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Asignar Línea
                            </a>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Esta línea no puede ser asignada debido a su estado: <strong>{{ $linea->estado }}</strong>
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
                            <h6 class="mb-1">Línea Ingresada al Almacén</h6>
                            <p class="text-muted mb-0">{{ $linea->fecha_ingreso_almacen->format('d/m/Y H:i') }}</p>
                            <small class="text-muted">Estado: {{ $linea->estado }}</small>
                        </div>
                    </div>
                    
                    @if($linea->fecha_asignacion)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Asignada a {{ $linea->persona->nombre_completo }}</h6>
                                <p class="text-muted mb-0">{{ $linea->fecha_asignacion->format('d/m/Y H:i') }}</p>
                                <small class="text-muted">Emisora: {{ $linea->persona->emisora->nombre }}</small>
                            </div>
                        </div>
                    @endif
                    
                    @if($linea->paquete)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-info">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Paquete Asignado: {{ $linea->paquete->nombre }}</h6>
                                <p class="text-muted mb-0">Paquete activo</p>
                                <small class="text-muted">{{ $linea->paquete->descripcion_completa }}</small>
                            </div>
                        </div>
                    @endif
                    
                    <div class="timeline-item">
                        <div class="timeline-marker bg-info">
                            <i class="fas fa-edit"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Última Actualización</h6>
                            <p class="text-muted mb-0">{{ $linea->updated_at->format('d/m/Y H:i') }}</p>
                            <small class="text-muted">Estado actual: {{ $linea->estado }}</small>
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
function devolverLinea() {
    if (confirm('¿Está seguro de que desea devolver esta línea al almacén?')) {
        $.ajax({
            url: '{{ route('lineas.devolver-almacen', $linea) }}',
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
                showNotification('Error al devolver la línea', 'error');
            }
        });
    }
}

function asignarPaquete() {
    // Implementar modal o redirección para asignar paquete
    window.location.href = '{{ route('lineas.edit', $linea) }}';
}

function quitarPaquete() {
    if (confirm('¿Está seguro de que desea quitar el paquete de esta línea?')) {
        $.ajax({
            url: '{{ route('lineas.quitar-paquete', $linea) }}',
            type: 'DELETE',
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
                showNotification('Error al quitar el paquete', 'error');
            }
        });
    }
}
</script>
@endpush