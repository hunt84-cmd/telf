@extends('layouts.app')

@section('title', 'Mi Perfil - Sistema de Emisoras')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0">
                <i class="fas fa-user-circle me-2"></i>Mi Perfil
            </h1>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Volver al Dashboard
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-edit me-2"></i>Editar Perfil
                </h6>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-user me-1"></i>Nombre <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-1"></i>Correo Electrónico <span class="text-danger">*</span>
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="current_password" class="form-label">
                                <i class="fas fa-key me-1"></i>Contraseña Actual
                            </label>
                            <input type="password" 
                                   class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" 
                                   name="current_password">
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Solo si quieres cambiar la contraseña</small>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="new_password" class="form-label">
                                <i class="fas fa-lock me-1"></i>Nueva Contraseña
                            </label>
                            <input type="password" 
                                   class="form-control @error('new_password') is-invalid @enderror" 
                                   id="new_password" 
                                   name="new_password">
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Mínimo 8 caracteres</small>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="new_password_confirmation" class="form-label">
                                <i class="fas fa-lock me-1"></i>Confirmar Nueva Contraseña
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="new_password_confirmation" 
                                   name="new_password_confirmation">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Actualizar Perfil
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
                    <i class="fas fa-info-circle me-2"></i>Información del Usuario
                </h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <i class="fas fa-user-circle fa-5x text-primary mb-3"></i>
                    <h5>{{ $user->name }}</h5>
                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }}">
                        {{ $user->role_name }}
                    </span>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Correo Electrónico:</label>
                    <p class="mb-0">{{ $user->email }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Rol:</label>
                    <p class="mb-0">{{ $user->role_name }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Estado:</label>
                    <p class="mb-0">
                        @if($user->is_active)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-danger">Inactivo</span>
                        @endif
                    </p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Miembro desde:</label>
                    <p class="mb-0">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Última actualización:</label>
                    <p class="mb-0">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
        
        <div class="card shadow mt-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-shield-alt me-2"></i>Seguridad
                </h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <h6><i class="fas fa-lightbulb me-2"></i>Consejos de Seguridad:</h6>
                    <ul class="mb-0">
                        <li>Usa una contraseña fuerte y única</li>
                        <li>No compartas tus credenciales</li>
                        <li>Cierra sesión al terminar</li>
                        <li>Cambia tu contraseña regularmente</li>
                    </ul>
                </div>
                
                <div class="d-grid">
                    <a href="{{ route('logout') }}" 
                       class="btn btn-danger"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                    </a>
                </div>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Validar que las contraseñas coincidan
    $('#new_password_confirmation').on('input', function() {
        const newPassword = $('#new_password').val();
        const confirmPassword = $(this).val();
        
        if (newPassword && confirmPassword && newPassword !== confirmPassword) {
            $(this).addClass('is-invalid');
            $(this).siblings('.invalid-feedback').remove();
            $(this).after('<div class="invalid-feedback">Las contraseñas no coinciden</div>');
        } else {
            $(this).removeClass('is-invalid');
            $(this).siblings('.invalid-feedback').remove();
        }
    });
    
    // Limpiar errores al escribir
    $('input').on('input', function() {
        $(this).removeClass('is-invalid');
    });
});
</script>
@endpush