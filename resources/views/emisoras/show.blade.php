@extends('layouts.app')

@section('title', $emisora->nombre . ' - Sistema de Emisoras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-broadcast-tower me-2"></i>{{ $emisora->nombre }}
            </h1>
            <div>
                <a href="{{ route('emisoras.edit', $emisora) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit me-2"></i>Editar
                </a>
                <a href="{{ route('emisoras.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Información de la Emisora -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-info-circle me-2"></i>Información General
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label fw-bold">Nombre:</label>
                    <p class="mb-0">{{ $emisora->nombre }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Responsable:</label>
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
        
        <!-- Estadísticas -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-bar me-2"></i>Estadísticas
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3">
                            <h4 class="text-info mb-1">{{ $emisora->personas->count() }}</h4>
                            <small class="text-muted">Personas</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3">
                            <h4 class="text-success mb-1">{{ $emisora->telefonos->count() }}</h4>
                            <small class="text-muted">Teléfonos</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3">
                            <h4 class="text-warning mb-1">{{ $emisora->lineas->count() }}</h4>
                            <small class="text-muted">Líneas</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3">
                            <h4 class="text-primary mb-1">{{ $emisora->lineas->whereNotNull('paquete_id')->count() }}</h4>
                            <small class="text-muted">Con Paquete</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Personas de la Emisora -->
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-users me-2"></i>Personas de la Emisora
                </h6>
                <a href="{{ route('personas.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i>Nueva Persona
                </a>
            </div>
            <div class="card-body">
                @if($emisora->personas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Nombre</th>
                                    <th>CI</th>
                                    <th>Teléfono</th>
                                    <th>Línea</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($emisora->personas as $persona)
                                <tr>
                                    <td>
                                        <strong>{{ $persona->nombre_completo }}</strong>
                                    </td>
                                    <td>{{ $persona->ci }}</td>
                                    <td>
                                        @if($persona->telefono)
                                            <span class="badge bg-success">
                                                <i class="fas fa-mobile-alt me-1"></i>{{ $persona->telefono->modelo }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Sin asignar</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($persona->linea)
                                            <span class="badge bg-info">
                                                <i class="fas fa-sim-card me-1"></i>{{ $persona->linea->numero_telefono }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">Sin asignar</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('personas.show', $persona) }}" 
                                               class="btn btn-sm btn-info" 
                                               title="Ver">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('personas.edit', $persona) }}" 
                                               class="btn btn-sm btn-warning" 
                                               title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No hay personas registradas</h5>
                        <p class="text-muted">Esta emisora aún no tiene personal asignado.</p>
                        <a href="{{ route('personas.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Registrar Primera Persona
                        </a>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Teléfonos Asignados -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-mobile-alt me-2"></i>Teléfonos Asignados
                </h6>
            </div>
            <div class="card-body">
                @php
                    $telefonosAsignados = $emisora->telefonos->whereNotNull('persona_id');
                @endphp
                
                @if($telefonosAsignados->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Modelo</th>
                                    <th>Estado</th>
                                    <th>Asignado a</th>
                                    <th>Fecha Asignación</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($telefonosAsignados as $telefono)
                                <tr>
                                    <td>{{ $telefono->modelo }}</td>
                                    <td>
                                        @if($telefono->estado_tecnico === 'Bueno')
                                            <span class="badge bg-success">Bueno</span>
                                        @elseif($telefono->estado_tecnico === 'Dañado')
                                            <span class="badge bg-warning">Dañado</span>
                                        @else
                                            <span class="badge bg-danger">Roto</span>
                                        @endif
                                    </td>
                                    <td>{{ $telefono->persona->nombre_completo }}</td>
                                    <td>{{ $telefono->fecha_asignacion ? $telefono->fecha_asignacion->format('d/m/Y') : 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('telefonos.show', $telefono) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-mobile-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No hay teléfonos asignados</h5>
                        <p class="text-muted">Esta emisora no tiene teléfonos asignados a su personal.</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Líneas Asignadas -->
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-sim-card me-2"></i>Líneas Asignadas
                </h6>
            </div>
            <div class="card-body">
                @php
                    $lineasAsignadas = $emisora->lineas->whereNotNull('persona_id');
                @endphp
                
                @if($lineasAsignadas->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>Número</th>
                                    <th>Estado</th>
                                    <th>Paquete</th>
                                    <th>Asignada a</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lineasAsignadas as $linea)
                                <tr>
                                    <td>{{ $linea->numero_telefono }}</td>
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
                                        @if($linea->paquete)
                                            <span class="badge bg-info">{{ $linea->paquete->nombre }}</span>
                                        @else
                                            <span class="badge bg-warning">Sin paquete</span>
                                        @endif
                                    </td>
                                    <td>{{ $linea->persona->nombre_completo }}</td>
                                    <td>
                                        <a href="{{ route('lineas.show', $linea) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-sim-card fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No hay líneas asignadas</h5>
                        <p class="text-muted">Esta emisora no tiene líneas asignadas a su personal.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection