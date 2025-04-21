@extends('layouts.app')

@section('title', 'Registro de Usuario - AstroMatch')

@section('styles')

@endsection

@section('content')
<section style="background: url('/images/fondo1.jpg') no-repeat center center; background-size: cover; min-height: 89vh; position: relative; overflow: hidden;" class="register-section">
    <div class="container register-container" data-aos="fade-up">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="register-card">
                    <h1 class="navbar-brand ">
                        <i class="bi bi-stars me-2"></i> Únete a AstroMatch
                    </h1>
                    
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    
                    <form action="{{ route('usuarios.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre" class="form-label">
                                        <i class="bi bi-person-fill me-2"></i>Nombre
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                                    </div>
                                    <div class="invalid-feedback">
                                        Por favor ingresa tu nombre
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-md-0 mt-2">
                                    <label for="apellido" class="form-label">
                                        <i class="bi bi-person-badge-fill me-2"></i>Apellido
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                                        <input type="text" class="form-control" id="apellido" name="apellido" value="{{ old('apellido') }}" required>
                                    </div>
                                    <div class="invalid-feedback">
                                        Por favor ingresa tu apellido
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mt-md-2 mt-2">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope-fill me-2"></i>Email
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="invalid-feedback">
                                Por favor ingresa un email válido
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group password-toggle mt-md-2 mt-2">
                                    <label for="contrasena" class="form-label">
                                        <i class="bi bi-lock-fill me-2"></i>Contraseña
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-key"></i></span>
                                        <input type="password" class="form-control" id="contrasena" name="contrasena" required minlength="8">
                                        
                                    </div>
                                    <div class="invalid-feedback">
                                        La contraseña debe tener al menos 8 caracteres
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group password-toggle mt-md-2 mt-2">
                                    <label for="contrasena_confirmation" class="form-label">
                                        <i class="bi bi-shield-lock-fill me-2"></i>Confirmar Contraseña
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                                        <input type="password" class="form-control" id="contrasena_confirmation" name="contrasena_confirmation" required>
                                        
                                    </div>
                                    <div class="invalid-feedback">
                                        Las contraseñas deben coincidir
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mt-md-2 mt-2">
                                    <label for="fecha_nacimiento" class="form-label">
                                        <i class="bi bi-calendar-heart-fill me-2"></i>Fecha de Nacimiento
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-calendar-date"></i></span>
                                        <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required>
                                    </div>
                                    <div class="invalid-feedback">
                                        Por favor ingresa tu fecha de nacimiento
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-md-2 mt-2">
                                    <label for="genero" class="form-label">
                                        <i class="bi bi-gender-ambiguous me-2"></i>Género
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-person-vcard"></i></span>
                                        <select class="form-select" id="genero" name="genero" required>
                                            <option value="" disabled selected>Selecciona una opción</option>
                                            <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                            <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback">
                                        Por favor selecciona tu género
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group form-check mt-4">
                            <div class="d-flex align-items-start">
                                <input type="checkbox" class="form-check-input mt-1" id="terms" name="terms" required>
                                <label class="form-check-label ms-2" for="terms">
                                    Acepto los 
                                    <a href="#" class="text-warning text-decoration-underline" target="_blank">Términos y Condiciones</a> 
                                    y la 
                                    <a href="#" class="text-warning text-decoration-underline" target="_blank">Política de Privacidad</a>
                                    <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="invalid-feedback terms-feedback">
                                <i class="bi bi-exclamation-circle-fill me-2"></i>Debes aceptar los términos y condiciones para continuar
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4 position-relative">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 py-3 cosmic-btn">
                                <span class="btn-content">
                                    <i class="bi bi-stars me-2"></i> Crear mi cuenta cósmica
                                </span>
                                <span class="cosmic-effect"></span>
                            </button>
                        </div>
                        
                        <div class="text-center mt-4">
                            <p class="text-light">¿Ya tienes una cuenta? <a  class="login-link">Inicia sesión aquí</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('js/register.js') }}"></script>
@endsection