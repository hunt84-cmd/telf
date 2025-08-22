@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Emisoras')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="h3 mb-4">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
        </h1>
    </div>
</div>

<!-- Estadísticas principales -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Emisoras
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_emisoras'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-broadcast-tower fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Personas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_personas'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Teléfonos
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_telefonos'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-mobile-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Líneas
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total_lineas'] }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-sim-card fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas del inventario -->
<div class="row mb-4">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-warehouse me-2"></i>Estado del Inventario
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="text-center">
                            <h4 class="text-primary">{{ $stats['telefonos_almacen'] }}</h4>
                            <p class="text-muted">Teléfonos en Almacén</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <h4 class="text-success">{{ $stats['telefonos_asignados'] }}</h4>
                            <p class="text-muted">Teléfonos Asignados</p>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        <div class="text-center">
                            <h4 class="text-info">{{ $stats['lineas_almacen'] }}</h4>
                            <p class="text-muted">Líneas en Almacén</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <h4 class="text-warning">{{ $stats['lineas_asignadas'] }}</h4>
                            <p class="text-muted">Líneas Asignadas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-box me-2"></i>Estado de Paquetes
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="text-center">
                            <h4 class="text-success">{{ $stats['lineas_con_paquete'] }}</h4>
                            <p class="text-muted">Líneas con Paquete</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <h4 class="text-warning">{{ $stats['lineas_sin_paquete'] }}</h4>
                            <p class="text-muted">Líneas sin Paquete</p>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="text-center">
                            <h4 class="text-info">{{ $stats['total_paquetes'] }}</h4>
                            <p class="text-muted">Total de Paquetes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Actividad reciente -->
<div class="row">
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-mobile-alt me-2"></i>Teléfonos Recientes
                </h6>
            </div>
            <div class="card-body">
                @if($recentActivity['telefonos']->count() > 0)
                    @foreach($recentActivity['telefonos'] as $telefono)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-mobile-alt text-primary"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">{{ $telefono->modelo }}</h6>
                                <small class="text-muted">
                                    @if($telefono->persona)
                                        Asignado a: {{ $telefono->persona->nombre_completo }}
                                    @else
                                        En almacén
                                    @endif
                                </small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">No hay teléfonos recientes</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-sim-card me-2"></i>Líneas Recientes
                </h6>
            </div>
            <div class="card-body">
                @if($recentActivity['lineas']->count() > 0)
                    @foreach($recentActivity['lineas'] as $linea)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-sim-card text-success"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">{{ $linea->numero_telefono }}</h6>
                                <small class="text-muted">
                                    @if($linea->persona)
                                        Asignada a: {{ $linea->persona->nombre_completo }}
                                    @else
                                        En almacén
                                    @endif
                                </small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">No hay líneas recientes</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-users me-2"></i>Personas Recientes
                </h6>
            </div>
            <div class="card-body">
                @if($recentActivity['personas']->count() > 0)
                    @foreach($recentActivity['personas'] as $persona)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <i class="fas fa-user text-info"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">{{ $persona->nombre_completo }}</h6>
                                <small class="text-muted">{{ $persona->emisora->nombre }}</small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center">No hay personas recientes</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Acciones rápidas -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-bolt me-2"></i>Acciones Rápidas
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('telefonos.create') }}" class="btn btn-primary btn-block w-100">
                            <i class="fas fa-plus me-2"></i>Nuevo Teléfono
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('lineas.create') }}" class="btn btn-success btn-block w-100">
                            <i class="fas fa-plus me-2"></i>Nueva Línea
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('personas.create') }}" class="btn btn-info btn-block w-100">
                            <i class="fas fa-plus me-2"></i>Nueva Persona
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('paquetes.create') }}" class="btn btn-warning btn-block w-100">
                            <i class="fas fa-plus me-2"></i>Nuevo Paquete
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.text-gray-300 {
    color: #dddfeb !important;
}
.text-gray-800 {
    color: #5a5c69 !important;
}
</style>
@endpush