@extends('layouts.app')

@section('title', $paquete->nombre . ' - Sistema de Emisoras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-box me-2"></i>{{ $paquete->nombre }}
            </h1>
            <div>
                <a href="{{ route('paquetes.edit', $paquete) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-2"></i>Editar
                </a>
                <a href="{{ route('paquetes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Información del Paquete -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>Información del Paquete
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nombre:</label>
                    <p class="mb-0">{{ $paquete->nombre }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Precio de Costo:</label>
                    <p class="mb-0">
                        <span class="h5 text-primary">{{ $paquete->precio_formateado }}</span>
                    </p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Descripción:</label>
                    <p class="mb-0">{{ $paquete->descripcion ?: 'Sin descripción' }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Fecha de Creación:</label>
                    <p class="mb-0">{{ $paquete->created_at->format('d/m/Y H:i') }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Última Actualización:</label>
                    <p class="mb-0">{{ $paquete->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
        
        <!-- Especificaciones -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-cogs me-2"></i>Especificaciones
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4 mb-3">
                        <div class="border rounded p-3">
                            <h4 class="text-info mb-1">{{ $paquete->cantidad_datos }}</h4>
                            <small class="text-muted">GB</small>
                        </div>
                    </div>
                    <div class="col-4 mb-3">
                        <div class="border rounded p-3">
                            <h4 class="text-success mb-1">{{ $paquete->cantidad_minutos }}</h4>
                            <small class="text-muted">Minutos</small>
                        </div>
                    </div>
                    <div class="col-4 mb-3">
                        <div class="border rounded p-3">
                            <h4 class="text-warning mb-1">{{ $paquete->cantidad_sms }}</h4>
                            <small class="text-muted">SMS</small>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-3">
                    <h6 class="text-muted">{{ $paquete->descripcion_completa }}</h6>
                </div>
            </div>
        </div>
        
        <!-- Estadísticas -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-bar me-2"></i>Estadísticas
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="border rounded p-4 mb-3">
                        <h3 class="text-primary mb-1">{{ $paquete->lineas->count() }}</h3>
                        <small class="text-muted">Líneas Asignadas</small>
                    </div>
                    
                    @if($paquete->lineas->count() > 0)
                        <div class="alert alert-info">
                            <small>
                                <i class="fas fa-info-circle me-1"></i>
                                Este paquete está siendo utilizado por {{ $paquete->lineas->count() }} línea(s)
                            </small>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <small>
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Este paquete no está siendo utilizado actualmente
                            </small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Líneas con este Paquete -->
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-sim-card me-2"></i>Líneas con este Paquete
                </h6>
            </div>
            <div class="card-body">
                @if($paquete->lineas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Número de Teléfono</th>
                                    <th>Estado</th>
                                    <th>Asignada a</th>
                                    <th>Emisora</th>
                                    <th>Fecha Asignación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paquete->lineas as $linea)
                                <tr>
                                    <td>
                                        <strong>{{ $linea->numero_telefono }}</strong>
                                    </td>
                                    <td>
                                        @if($linea->estado === 'Activa')
                                            <span class="badge bg-success">Activa</span>
                                        @elseif($linea->estado === 'Inactiva')
                                            <span class="badge bg-secondary">Inactiva</span>
                                        @else
                                            <span class="badge bg-danger">Suspendida</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($linea->persona)
                                            <span class="badge bg-info">{{ $linea->persona->nombre_completo }}</span>
                                        @else
                                            <span class="badge bg-secondary">Sin asignar</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($linea->persona)
                                            <span class="badge bg-primary">{{ $linea->persona->emisora->nombre }}</span>
                                        @else
                                            <span class="badge bg-secondary">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $linea->fecha_asignacion ? $linea->fecha_asignacion->format('d/m/Y') : 'N/A' }}
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('lineas.show', $linea) }}" 
                                               class="btn btn-sm btn-info" 
                                               title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($linea->persona)
                                                <a href="{{ route('personas.show', $linea->persona) }}" 
                                                   class="btn btn-sm btn-success" 
                                                   title="Ver Persona">
                                                    <i class="fas fa-user"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-sim-card fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No hay líneas con este paquete</h5>
                        <p class="text-muted">Este paquete no está siendo utilizado por ninguna línea actualmente.</p>
                        <a href="{{ route('lineas.almacen') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Asignar a Líneas del Almacén
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection