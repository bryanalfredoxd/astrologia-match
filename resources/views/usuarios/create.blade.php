@extends('layouts.app')

@section('title', 'Registro de Usuario - AstroMatch')

@section('styles')
<style>
    :root {
        --primary-light: #9d4edd;
        --secondary-light: #ff5d8f;
        --accent-light: #ffbe0b;
        --dark-light: #1a1a40;
        --light-light: #f8f9fa;
    }
    
    .register-section {
        background: linear-gradient(135deg, #2a0b52, #1a0936);
        padding: 100px 0;
        min-height: 100vh;
        position: relative;
        overflow: hidden;
    }
    
    .register-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path fill="rgba(255,255,255,0.03)" d="M0,0 L100,0 L100,100 L0,100 Z" /><circle cx="20" cy="20" r="3" fill="rgba(255,255,255,0.1)" /><circle cx="80" cy="20" r="2" fill="rgba(255,255,255,0.1)" /><circle cx="50" cy="50" r="4" fill="rgba(255,255,255,0.1)" /><circle cx="30" cy="70" r="3" fill="rgba(255,255,255,0.1)" /><circle cx="70" cy="80" r="2" fill="rgba(255,255,255,0.1)" /></svg>');
        background-size: cover;
    }
    
    .register-container {
        position: relative;
        z-index: 2;
    }
    
    .register-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(12px);
        border-radius: 20px;
        padding: 40px;
        border: 1px solid rgba(157, 78, 221, 0.4);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.1);
        max-width: 800px;
        margin: 0 auto;
    }
    
    .register-title {
        font-weight: 700;
        margin-bottom: 30px;
        text-align: center;
        background: linear-gradient(45deg, var(--accent-light), var(--secondary-light));
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        font-size: 2.5rem;
    }
    
    .form-label {
        color: #e0c3fc;
        font-weight: 500;
        margin-bottom: 8px;
        display: block;
    }
    
    .form-control {
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(157, 78, 221, 0.6);
        color: white;
        padding: 12px 20px;
        border-radius: 10px;
        transition: all 0.3s ease;
    }
    
    .form-control:focus {
        background: rgba(255, 255, 255, 0.25);
        border-color: var(--primary-light);
        box-shadow: 0 0 0 0.25rem rgba(157, 78, 221, 0.3);
        color: white;
    }
    
    .form-select {
        background: rgba(255, 255, 255, 0.15) url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='%23e0c3fc' stroke='%23e0c3fc' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e") no-repeat right 0.75rem center/16px 12px;
        color: white;
        border: 1px solid rgba(157, 78, 221, 0.6);
    }
    
    .form-select:focus {
        border-color: var(--primary-light);
        box-shadow: 0 0 0 0.25rem rgba(157, 78, 221, 0.3);
    }
    
    .btn-register {
        background: linear-gradient(45deg, var(--primary-light), var(--secondary-light));
        border: none;
        padding: 15px 40px;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        transition: all 0.3s ease;
        box-shadow: 0 4px 20px rgba(157, 78, 221, 0.5);
        border-radius: 50px; /* Más redondeado */
        font-size: 1.1rem;
        position: relative;
        overflow: hidden;
        z-index: 1;
        min-width: 250px; /* Ancho mínimo */
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-register::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(45deg, var(--secondary-light), var(--primary-light));
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: -1;
    }

    .btn-register:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 8px 25px rgba(157, 78, 221, 0.7);
    }

    .btn-register:hover::before {
        opacity: 1;
    }

    .btn-register:active {
        transform: translateY(1px);
    }
    
    .alert-success {
        background-color: rgba(40, 167, 69, 0.25);
        border: 1px solid rgba(40, 167, 69, 0.4);
        color: #d4edda;
        backdrop-filter: blur(5px);
        border-radius: 10px;
    }
    
    .alert-danger {
        background-color: rgba(220, 53, 69, 0.25);
        border: 1px solid rgba(220, 53, 69, 0.4);
        color: #f8d7da;
        backdrop-filter: blur(5px);
        border-radius: 10px;
    }
    
    .form-group {
        margin-bottom: 25px;
    }
    
    .form-text {
        color: #b3a1d8;
        font-size: 0.85rem;
    }
    
    .password-toggle {
        position: relative;
    }
    
    .password-toggle-icon {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: #b3a1d8;
        cursor: pointer;
        font-size: 1.2rem;
    }
    
    .form-check-input {
    width: 1.2em;
    height: 1.2em;
    margin-top: 0.15em;
}

.form-check-label {
    color: #e0c3fc;
    line-height: 1.5;
}

.form-check-label a {
    color: var(--accent-light);
    text-decoration: underline;
    font-weight: 500;
    transition: all 0.2s ease;
}

.form-check-label a:hover {
    color: var(--secondary-light);
    text-decoration: none;
}

.invalid-feedback {
    font-size: 0.9rem;
    margin-top: 8px;
    padding-left: 1.5em;
    color: #ff6b6b;
}
    
    .login-link {
        color: var(--accent-light);
        font-weight: 500;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .login-link:hover {
        color: var(--secondary-light);
        text-decoration: underline;
    }
    
    @media (max-width: 768px) {
        .register-section {
            padding: 80px 0;
        }
        
        .register-card {
            padding: 30px 20px;
            border-radius: 15px;
        }
        
        .register-title {
            font-size: 2rem;
        }
    }

    .cosmic-btn {
    --btn-primary: #8A2BE2;
    --btn-secondary: #FF1493;
    --btn-accent: #F5C518;
    
    position: relative;
    overflow: hidden;
    border: none;
    background: linear-gradient(45deg, var(--btn-primary), var(--btn-secondary));
    font-weight: 600;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    transition: all 0.4s ease;
    z-index: 1;
    box-shadow: 0 4px 15px rgba(138, 43, 226, 0.6);
    min-width: 280px;
    border: 2px solid rgba(255, 255, 255, 0.15);
}

.cosmic-btn .btn-content {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: center;
}

.cosmic-btn .bi-stars {
    transition: all 0.4s ease;
}

.cosmic-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 25px rgba(138, 43, 226, 0.8);
}

.cosmic-btn:active {
    transform: translateY(1px);
}

.cosmic-effect {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(45deg, var(--btn-secondary), var(--btn-primary));
    opacity: 0;
    transition: opacity 0.4s ease;
    z-index: 1;
}

.cosmic-btn:hover .cosmic-effect {
    opacity: 1;
}

/* Animación al hacer clic */
@keyframes cosmicPulse {
    0% {
        box-shadow: 0 0 0 0 rgba(245, 197, 24, 0.7);
    }
    70% {
        box-shadow: 0 0 0 15px rgba(245, 197, 24, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(245, 197, 24, 0);
    }
}

@keyframes starShine {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.5);
        opacity: 0.8;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

.cosmic-btn.clicked {
    animation: cosmicPulse 0.8s ease-out;
}

.cosmic-btn.clicked .bi-stars {
    animation: starShine 0.6s ease-in-out;
}

/* Estilo para el checkbox inválido */
.is-invalid {
    border-color: #dc3545 !important;
}

.is-invalid ~ .form-check-label {
    color: #ff6b6b;
}

.terms-feedback {
    display: none;
    font-size: 0.9rem;
    margin-top: 8px;
    padding-left: 1.8em;
    color: #ff6b6b;
}

/* Estilo para el asterisco de campo requerido */
.text-danger {
    color: #ff6b6b !important;
    font-weight: bold;
    margin-left: 3px;
}
</style>
@endsection

@section('content')
<section class="register-section">
    <div class="container register-container" data-aos="fade-up">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="register-card">
                    <h1 class="navbar-brand">
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
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                                    <div class="invalid-feedback">
                                        Por favor ingresa tu nombre
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="apellido" class="form-label">Apellido</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" value="{{ old('apellido') }}" required>
                                    <div class="invalid-feedback">
                                        Por favor ingresa tu apellido
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                            <div class="invalid-feedback">
                                Por favor ingresa un email válido
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group password-toggle">
                                    <label for="contrasena" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" id="contrasena" name="contrasena" required minlength="8">
                                    <i class="bi password-toggle-icon" id="togglePassword"></i>
                                    <div class="invalid-feedback">
                                        La contraseña debe tener al menos 8 caracteres
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group password-toggle">
                                    <label for="contrasena_confirmation" class="form-label">Confirmar Contraseña</label>
                                    <input type="password" class="form-control" id="contrasena_confirmation" name="contrasena_confirmation" required>
                                    <i class="bi password-toggle-icon" id="toggleConfirmPassword"></i>
                                    <div class="invalid-feedback">
                                        Las contraseñas deben coincidir
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required>
                                    <div class="invalid-feedback">
                                        Por favor ingresa tu fecha de nacimiento
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="genero" class="form-label">Género</label>
                                    <select class="form-select" id="genero" name="genero" required>
                                        <option value="" disabled selected>Selecciona una opción</option>
                                        <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                        <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                        
                                    </select>
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
<script>
    // Toggle para mostrar/ocultar contraseña
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#contrasena');
    
    const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
    const confirmPassword = document.querySelector('#contrasena_confirmation');
    
    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });
    
    toggleConfirmPassword.addEventListener('click', function() {
        const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPassword.setAttribute('type', type);
        this.classList.toggle('bi-eye');
        this.classList.toggle('bi-eye-slash');
    });
    
    // Validación de formulario con Bootstrap
    (function() {
        'use strict';
        
        var forms = document.querySelectorAll('.needs-validation');
        
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    
                    form.classList.add('was-validated');
                }, false);
            });
    })();

    // Validación de formulario
    (function() {
        'use strict';
        
        var forms = document.querySelectorAll('.needs-validation');
        
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    
                    form.classList.add('was-validated');
                }, false);
            });
    })();
    
    // Inicializar AOS para animaciones
    AOS.init({
        duration: 800,
        easing: 'ease-in-out',
        once: true
    });

    document.addEventListener('DOMContentLoaded', function() {
    const cosmicBtn = document.querySelector('.cosmic-btn');
    
    if(cosmicBtn) {
        cosmicBtn.addEventListener('click', function(e) {
            // Solo animar si el formulario es válido
            const form = this.closest('form');
            if(form && form.checkValidity()) {
                this.classList.add('clicked');
                
                // Remover la clase después de la animación
                setTimeout(() => {
                    this.classList.remove('clicked');
                }, 800);
                
                // Animación del icono de estrellas
                const starIcon = this.querySelector('.bi-stars');
                if(starIcon) {
                    starIcon.style.transform = 'scale(1.5)';
                    setTimeout(() => {
                        starIcon.style.transform = 'scale(1)';
                    }, 300);
                }
            }
        });
    }
    });

    document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const termsCheckbox = document.getElementById('terms');
    const termsFeedback = document.querySelector('.terms-feedback');
    
    if(form) {
        // Validación al enviar el formulario
        form.addEventListener('submit', function(e) {
            if(!termsCheckbox.checked) {
                e.preventDefault();
                termsCheckbox.classList.add('is-invalid');
                termsFeedback.style.display = 'block';
                
                // Scroll suave al campo no válido
                termsCheckbox.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        });
        
        // Validación en tiempo real
        termsCheckbox.addEventListener('change', function() {
            if(this.checked) {
                this.classList.remove('is-invalid');
                termsFeedback.style.display = 'none';
            } else {
                this.classList.add('is-invalid');
                termsFeedback.style.display = 'block';
            }
        });
    }
});
</script>
@endsection