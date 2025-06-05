{{-- resources/views/groq-response.blade.php --}}
@extends('layouts.app_sesion')

@section('content')
<section class="bg-[#0A0E2A] text-white min-h-screen p-4 sm:p-6 flex items-center justify-center relative overflow-hidden">
    <!-- Efectos de fondo decorativos -->
    <div class="absolute -top-20 -right-20 w-64 h-64 bg-[#FFD700] bg-opacity-5 rounded-full"></div>
    <div class="absolute -bottom-32 -left-32 w-80 h-80 bg-[#FFD700] bg-opacity-5 rounded-full"></div>
    
    <div class="max-w-2xl w-full mx-auto bg-gradient-to-br from-[#1A1F4D] to-[#0A0E2A] rounded-xl p-6 sm:p-8 shadow-xl border border-[#FFD700] relative z-10">
        <!-- Encabezado con icono -->
        <div class="flex items-center justify-center mb-6">
            <div class="bg-[#FFD700] bg-opacity-20 p-3 rounded-full mr-3">
                <i class="fas fa-user-edit text-[#FFD700] text-xl"></i>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold text-[#FFD700] text-center">Editar Perfil</h2>
        </div>

        <form id="profile-edit-form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Sección de Datos Básicos -->
            <div class="bg-[#0A0E2A] bg-opacity-50 p-4 rounded-lg border border-[#3A3F6D]">
                <h3 class="text-lg font-semibold text-[#A7B3EB] mb-4 flex items-center">
                    <i class="fas fa-id-card mr-2 text-[#FFD700]"></i> Información Básica
                </h3>
                
                <div class="space-y-4">
                    <!-- Nombre Completo -->
                    <div>
                        <label for="nombre_completo" class="block text-[#A7B3EB] mb-2">Nombre Completo</label>
                        <input type="text" id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo', $user->nombre_completo) }}"
                            class="w-full bg-[#0A0E2A] border border-[#3A3F6D] rounded-lg px-4 py-3 text-white focus:border-[#FFD700] focus:ring-1 focus:ring-[#FFD700] transition duration-200">
                        @error('nombre_completo')
                            <p class="mt-1 text-red-400 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-[#A7B3EB] mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full bg-[#0A0E2A] border border-[#3A3F6D] rounded-lg px-4 py-3 text-white focus:border-[#FFD700] focus:ring-1 focus:ring-[#FFD700] transition duration-200">
                        @error('email')
                            <p class="mt-1 text-red-400 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sección de Contraseña -->
            <div class="bg-[#0A0E2A] bg-opacity-50 p-4 rounded-lg border border-[#3A3F6D]">
                <h3 class="text-lg font-semibold text-[#A7B3EB] mb-4 flex items-center">
                    <i class="fas fa-lock mr-2 text-[#FFD700]"></i> Seguridad
                </h3>
                
                <div class="space-y-4">
                    <!-- Contraseña -->
                    <div>
                        <label for="password" class="block text-[#A7B3EB] mb-2">Nueva Contraseña</label>
                        <div class="relative">
                            <input type="password" id="password" name="password"
                                class="w-full bg-[#0A0E2A] border border-[#3A3F6D] rounded-lg px-4 py-3 text-white focus:border-[#FFD700] focus:ring-1 focus:ring-[#FFD700] transition duration-200">
                            <button type="button" class="absolute right-3 top-3 text-[#A7B3EB] hover:text-[#FFD700]" onclick="togglePassword('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <p class="mt-1 text-xs text-[#A7B3EB]">Dejar en blanco para no cambiar</p>
                        @error('password')
                            <p class="mt-1 text-red-400 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div>
                        <label for="password_confirmation" class="block text-[#A7B3EB] mb-2">Confirmar Contraseña</label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="w-full bg-[#0A0E2A] border border-[#3A3F6D] rounded-lg px-4 py-3 text-white focus:border-[#FFD700] focus:ring-1 focus:ring-[#FFD700] transition duration-200">
                            <button type="button" class="absolute right-3 top-3 text-[#A7B3EB] hover:text-[#FFD700]" onclick="togglePassword('password_confirmation')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección de Información Personal -->
            <div class="bg-[#0A0E2A] bg-opacity-50 p-4 rounded-lg border border-[#3A3F6D]">
                <h3 class="text-lg font-semibold text-[#A7B3EB] mb-4 flex items-center">
                    <i class="fas fa-user-tag mr-2 text-[#FFD700]"></i> Sobre Ti
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Género -->
                    <div>
                        <label for="genero" class="block text-[#A7B3EB] mb-2">Género</label>
                        <select id="genero" name="genero"
                            class="w-full bg-[#0A0E2A] border border-[#3A3F6D] rounded-lg px-4 py-3 text-white focus:border-[#FFD700] focus:ring-1 focus:ring-[#FFD700] transition duration-200">
                            <option value="">Selecciona tu género</option>
                            <option value="Masculino" {{ old('genero', $user->genero) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="Femenino" {{ old('genero', $user->genero) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                            <option value="No binario" {{ old('genero', $user->genero) == 'No binario' ? 'selected' : '' }}>No binario</option>
                            <option value="Otro" {{ old('genero', $user->genero) == 'Otro' ? 'selected' : '' }}>Otro</option>
                            <option value="Prefiero no decir" {{ old('genero', $user->genero) == 'Prefiero no decir' ? 'selected' : '' }}>Prefiero no decir</option>
                        </select>
                        @error('genero')
                            <p class="mt-1 text-red-400 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Orientación Sexual -->
                    <div>
                        <label for="orientacion_sexual" class="block text-[#A7B3EB] mb-2">Orientación</label>
                        <select id="orientacion_sexual" name="orientacion_sexual"
                            class="w-full bg-[#0A0E2A] border border-[#3A3F6D] rounded-lg px-4 py-3 text-white focus:border-[#FFD700] focus:ring-1 focus:ring-[#FFD700] transition duration-200">
                            <option value="">Selecciona tu orientación</option>
                            <option value="Heterosexual" {{ old('orientacion_sexual', $user->orientacion_sexual) == 'Heterosexual' ? 'selected' : '' }}>Heterosexual</option>
                            <option value="Homosexual" {{ old('orientacion_sexual', $user->orientacion_sexual) == 'Homosexual' ? 'selected' : '' }}>Homosexual</option>
                            <option value="Bisexual" {{ old('orientacion_sexual', $user->orientacion_sexual) == 'Bisexual' ? 'selected' : '' }}>Bisexual</option>
                            <option value="Pansexual" {{ old('orientacion_sexual', $user->orientacion_sexual) == 'Pansexual' ? 'selected' : '' }}>Pansexual</option>
                            <option value="Asexual" {{ old('orientacion_sexual', $user->orientacion_sexual) == 'Asexual' ? 'selected' : '' }}>Asexual</option>
                            <option value="Prefiero no decir" {{ old('orientacion_sexual', $user->orientacion_sexual) == 'Prefiero no decir' ? 'selected' : '' }}>Prefiero no decir</option>
                        </select>
                        @error('orientacion_sexual')
                            <p class="mt-1 text-red-400 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sección de Ubicación -->
            <div class="bg-[#0A0E2A] bg-opacity-50 p-4 rounded-lg border border-[#3A3F6D]">
                <h3 class="text-lg font-semibold text-[#A7B3EB] mb-4 flex items-center">
                    <i class="fas fa-map-marker-alt mr-2 text-[#FFD700]"></i> Ubicación
                </h3>
                
                <div class="space-y-4">
                    <!-- Latitud y Longitud -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="latitud" class="block text-[#A7B3EB] mb-2">Latitud</label>
                            <input type="text" id="latitud" name="latitud" value="{{ old('latitud', $user->latitud) }}" placeholder="Ej: 10.123456"
                                class="w-full bg-[#0A0E2A] border border-[#3A3F6D] rounded-lg px-4 py-3 text-white focus:border-[#FFD700] focus:ring-1 focus:ring-[#FFD700] transition duration-200">
                            @error('latitud')
                                <p class="mt-1 text-red-400 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="longitud" class="block text-[#A7B3EB] mb-2">Longitud</label>
                            <input type="text" id="longitud" name="longitud" value="{{ old('longitud', $user->longitud) }}" placeholder="Ej: -66.123456"
                                class="w-full bg-[#0A0E2A] border border-[#3A3F6D] rounded-lg px-4 py-3 text-white focus:border-[#FFD700] focus:ring-1 focus:ring-[#FFD700] transition duration-200">
                            @error('longitud')
                                <p class="mt-1 text-red-400 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <button type="button" id="get-location-btn" class="flex items-center justify-center w-full md:w-auto px-4 py-2 bg-[#FFD700] bg-opacity-20 text-[#FFD700] rounded-lg hover:bg-opacity-30 transition duration-200">
                        <i class="fas fa-location-arrow mr-2"></i> Usar mi ubicación actual
                    </button>
                </div>
            </div>

            <!-- Sección de Biografía y Foto -->
            <div class="bg-[#0A0E2A] bg-opacity-50 p-4 rounded-lg border border-[#3A3F6D]">
                <h3 class="text-lg font-semibold text-[#A7B3EB] mb-4 flex items-center">
                    <i class="fas fa-pen-fancy mr-2 text-[#FFD700]"></i> Presentación
                </h3>
                
                <div class="space-y-4">
                    <!-- Biografía -->
                    <div>
                        <label for="biografia" class="block text-[#A7B3EB] mb-2">Biografía</label>
                        <textarea id="biografia" name="biografia" rows="4"
                            class="w-full bg-[#0A0E2A] border border-[#3A3F6D] rounded-lg px-4 py-3 text-white focus:border-[#FFD700] focus:ring-1 focus:ring-[#FFD700] transition duration-200">{{ old('biografia', $user->biografia) }}</textarea>
                        @error('biografia')
                            <p class="mt-1 text-red-400 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Foto de Perfil -->
                    <div>
                        <label class="block text-[#A7B3EB] mb-2">Foto de Perfil</label>
                        @if($user->foto_perfil_url)
                            <div class="mb-4 flex items-center">
                                <img src="{{ asset($user->foto_perfil_url) }}" alt="Foto actual" class="w-16 h-16 rounded-full object-cover mr-4 border border-[#FFD700]">
                                <span class="text-sm text-[#A7B3EB]">Foto actual</span>
                            </div>
                        @endif
                        
                        <div class="flex items-center justify-center w-full">
                            <label for="foto_perfil" class="flex flex-col items-center justify-center w-full h-32 border-2 border-[#3A3F6D] border-dashed rounded-lg cursor-pointer bg-[#0A0E2A] hover:border-[#FFD700] transition duration-200">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <i class="fas fa-cloud-upload-alt text-2xl text-[#FFD700] mb-2"></i>
                                    <p class="mb-2 text-sm text-[#A7B3EB]">Haz clic para subir una foto</p>
                                    <p class="text-xs text-[#A7B3EB]">PNG, JPG (MAX. 2MB)</p>
                                </div>
                                <input id="foto_perfil" name="foto_perfil" type="file" class="hidden" accept="image/*">
                            </label>
                        </div>
                        @error('foto_perfil')
                            <p class="mt-1 text-red-400 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="flex flex-col sm:flex-row justify-between space-y-3 sm:space-y-0 sm:space-x-4 pt-4">
                <a href="{{ route('astromatch') }}" class="px-6 py-3 bg-[#3A3F6D] text-white font-bold rounded-full hover:bg-[#4A4F7D] transition duration-200 flex items-center justify-center">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
                <button type="submit" class="px-6 py-3 bg-[#FFD700] text-[#0A0E2A] font-bold rounded-full hover:bg-white transition duration-200 flex items-center justify-center">
                    <i class="fas fa-save mr-2"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mostrar/ocultar contraseña
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling.querySelector('i');
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // Obtener ubicación actual
        document.getElementById('get-location-btn').addEventListener('click', function() {
            const btn = this;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Detectando...';
            btn.disabled = true;
            
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        document.getElementById('latitud').value = position.coords.latitude.toFixed(6);
                        document.getElementById('longitud').value = position.coords.longitude.toFixed(6);
                        btn.innerHTML = '<i class="fas fa-check mr-2"></i> Ubicación obtenida';
                        setTimeout(() => {
                            btn.innerHTML = '<i class="fas fa-location-arrow mr-2"></i> Usar mi ubicación actual';
                            btn.disabled = false;
                        }, 2000);
                    },
                    function(error) {
                        let errorMsg = 'Error al obtener ubicación';
                        if (error.code === error.PERMISSION_DENIED) {
                            errorMsg = 'Permiso denegado. Por favor habilita la geolocalización en tu navegador.';
                        }
                        alert(errorMsg);
                        btn.innerHTML = '<i class="fas fa-location-arrow mr-2"></i> Usar mi ubicación actual';
                        btn.disabled = false;
                    }
                );
            } else {
                alert('Tu navegador no soporta geolocalización');
                btn.innerHTML = '<i class="fas fa-location-arrow mr-2"></i> Usar mi ubicación actual';
                btn.disabled = false;
            }
        });

        // Mostrar nombre de archivo al seleccionar imagen
        document.getElementById('foto_perfil').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'Ningún archivo seleccionado';
            const uploadArea = this.parentElement;
            uploadArea.querySelector('p:first-of-type').textContent = fileName;
        });
    });
</script>
@endsection