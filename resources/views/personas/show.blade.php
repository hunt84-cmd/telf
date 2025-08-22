@extends('layouts.app')

@section('title', $persona->nombre_completo . ' - Sistema de Emisoras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-user me-2"></i>{{ $persona->nombre_completo }}
            </h1>
            <div>
                <a href="{{ route('personas.edit', $persona) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-2"></i>Editar
                </a>
                <a href="{{ route('personas.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Información de la Persona -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>Información Personal
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nombre:</label>
                    <p class="mb-0">{{ $persona->nombre }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Apellidos:</label>
                    <p class="mb-0">{{ $persona->apellidos }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Cédula de Identidad:</label>
                    <p class="mb-0">{{ $persona->ci }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Emisora:</label>
                    <p class="mb-0">
                        <span class="badge bg-primary">{{ $persona->emisora->nombre }}</span>
                    </p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Responsable de Emisora:</label>
                    <p class="mb-0">{{ $persona->emisora->responsable }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Fecha de Registro:</label>
                    <p class="mb-0">{{ $persona->created_at->format('d/m/Y H:i') }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Última Actualización:</label>
                    <p class="mb-0">{{ $persona->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
        
        <!-- Estado de Asignaciones -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-bar me-2"></i>Estado de Asignaciones
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3">
                            @if($persona->telefono)
                                <h4 class="text-success mb-1">
                                    <i class="fas fa-check"></i>
                                </h4>
                                <small class="text-muted">Teléfono Asignado</small>
                            @else
                                <h4 class="text-warning mb-1">
                                    <i class="fas fa-times"></i>
                                </h4>
                                <small class="text-muted">Sin Teléfono</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3">
                            @if($persona->linea)
                                <h4 class="text-success mb-1">
                                    <i class="fas fa-check"></i>
                                </h4>
                                <small class="text-muted">Línea Asignada</small>
                            @else
                                <h4 class="text-warning mb-1">
                                    <i class="fas fa-times"></i>
                                </h4>
                                <small class="text-muted">Sin Línea</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Teléfono Asignado -->
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-mobile-alt me-2"></i>Teléfono Asignado
                </h6>
                @if(!$persona->telefono)
                    <a href="{{ route('telefonos.almacen') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i>Asignar Teléfono
                    </a>
                @endif
            </div>
            <div class="card-body">
                @if($persona->telefono)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Modelo:</label>
                                <p class="mb-0">{{ $persona->telefono->modelo }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Estado Técnico:</label>
                                <p class="mb-0">
                                    @if($persona->telefono->estado_tecnico === 'Bueno')
                                        <span class="badge bg-success">Bueno</span>
                                    @elseif($persona->telefono->estado_tecnico === 'Dañado')
                                        <span class="badge bg-warning">Dañado</span>
                                    @else
                                        <span class="badge bg-danger">Roto</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Fecha de Asignación:</label>
                                <p class="mb-0">{{ $persona->telefono->fecha_asignacion ? $persona->telefono->fecha_asignacion->format('d/m/Y H:i') : 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Fecha de Ingreso al Almacén:</label>
                                <p class="mb-0">{{ $persona->telefono->fecha_ingreso_almacen->format('d/m/Y H:i') }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Observaciones:</label>
                                <p class="mb-0">{{ $persona->telefono->observaciones ?: 'Sin observaciones' }}</p>
                            </div>
                            
                            <div class="mt-4">
                                <a href="{{ route('telefonos.show', $persona->telefono) }}" class="btn btn-info me-2">
                                    <i class="fas fa-eye me-1"></i>Ver Teléfono
                                </a>
                                <button type="button" class="btn btn-warning" onclick="devolverTelefono()">
                                    <i class="fas fa-undo me-1"></i>Devolver al Almacén
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-mobile-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No tiene teléfono asignado</h5>
                        <p class="text-muted">Esta persona no tiene un teléfono asignado actualmente.</p>
                        <a href="{{ route('telefonos.almacen') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Asignar Teléfono del Almacén
                        </a>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Línea Asignada -->
        <div class="card shadow">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-sim-card me-2"></i>Línea Asignada
                </h6>
                @if(!$persona->linea)
                    <a href="{{ route('lineas.almacen') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i>Asignar Línea
                    </a>
                @endif
            </div>
            <div class="card-body">
                @if($persona->linea)
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Número de Teléfono:</label>
                                <p class="mb-0">{{ $persona->linea->numero_telefono }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Estado:</label>
                                <p class="mb-0">
                                    @if($persona->linea->estado === 'Activa')
                                        <span class="badge bg-success">Activa</span>
                                    @elseif($persona->linea->estado === 'Inactiva')
                                        <span class="badge bg-secondary">Inactiva</span>
                                    @else
                                        <span class="badge bg-danger">Suspendida</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Fecha de Asignación:</label>
                                <p class="mb-0">{{ $persona->linea->fecha_asignacion ? $persona->linea->fecha_asignacion->format('d/m/Y H:i') : 'N/A' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Paquete Asignado:</label>
                                @if($persona->linea->paquete)
                                    <p class="mb-0">
                                        <span class="badge bg-info">{{ $persona->linea->paquete->nombre }}</span>
                                        <br>
                                        <small class="text-muted">
                                            {{ $persona->linea->paquete->cantidad_datos }}GB, 
                                            {{ $persona->linea->paquete->cantidad_minutos }} min, 
                                            {{ $persona->linea->paquete->cantidad_sms }} SMS
                                        </small>
                                    </p>
                                @else
                                    <p class="mb-0">
                                        <span class="badge bg-warning">Sin paquete asignado</span>
                                    </p>
                                @endif
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Fecha de Ingreso al Almacén:</label>
                                <p class="mb-0">{{ $persona->linea->fecha_ingreso_almacen->format('d/m/Y H:i') }}</p>
                            </div>
                            
                            <div class="mt-4">
                                <a href="{{ route('lineas.show', $persona->linea) }}" class="btn btn-info me-2">
                                    <i class="fas fa-eye me-1"></i>Ver Línea
                                </a>
                                <button type="button" class="btn btn-warning" onclick="devolverLinea()">
                                    <i class="fas fa-undo me-1"></i>Devolver al Almacén
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-sim-card fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No tiene línea asignada</h5>
                        <p class="text-muted">Esta persona no tiene una línea asignada actualmente.</p>
                        <a href="{{ route('lineas.almacen') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Asignar Línea del Almacén
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
function devolverTelefono() {
    if (confirm('¿Está seguro de que desea devolver el teléfono al almacén?')) {
        $.ajax({
            url: '{{ route('telefonos.devolver-almacen', $persona->telefono) }}',
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

function devolverLinea() {
    if (confirm('¿Está seguro de que desea devolver la línea al almacén?')) {
        $.ajax({
            url: '{{ route('lineas.devolver-almacen', $persona->linea) }}',
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
</script>
@endpush