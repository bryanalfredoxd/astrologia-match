{{-- resources/views/groq-response.blade.php --}}
@extends('layouts.app_sesion')

@section('content')
{{-- Change background to match astromatch --}}
<section class="bg-[#0A0E2A] text-white min-h-screen p-4 sm:p-6 relative overflow-hidden pb-20 sm:pb-20">
    {{-- Include the header from astromatch --}}
    @include('partials.header')

    <div class="max-w-4xl mx-auto relative z-10 px-2 sm:px-4">
        {{-- Adjust card background and border to match profile-card in astromatch --}}
        <div class="bg-gradient-to-r from-[#4A0E7B] to-[#1A1F4D] rounded-2xl shadow-xl border border-[#FFD700]/30 overflow-hidden mb-6">
            <div class="p-4 sm:p-6 md:p-8">
                <h2 class="text-2xl sm:text-3xl font-bold text-center mb-4 sm:mb-6 text-[#FFD700]">
                    <i class="fas fa-user-edit mr-2"></i> Editar Perfil
                </h2>

                <form id="profile-edit-form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4 sm:space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <label for="nombre_completo" class="block text-[#A7B3EB] mb-1 sm:mb-2 text-sm sm:text-base">
                                <i class="fas fa-user mr-2"></i> Nombre Completo
                            </label>
                            <input type="text" id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo', $user->nombre_completo) }}"
                                   class="w-full bg-[#0A0E2A]/70 border border-[#4A0E7B] rounded-lg px-3 py-2 sm:px-4 sm:py-3 text-white focus:border-[#FFD700] focus:ring-[#FFD700] placeholder-[#A7B3EB]/50 text-sm sm:text-base">
                            @error('nombre_completo')
                            <p class="mt-1 text-red-400 text-xs sm:text-sm flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-[#A7B3EB] mb-1 sm:mb-2 text-sm sm:text-base">
                                <i class="fas fa-envelope mr-2"></i> Email
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                   class="w-full bg-[#0A0E2A]/70 border border-[#4A0E7B] rounded-lg px-3 py-2 sm:px-4 sm:py-3 text-white focus:border-[#FFD700] focus:ring-[#FFD700] placeholder-[#A7B3EB]/50 text-sm sm:text-base">
                            @error('email')
                            <p class="mt-1 text-red-400 text-xs sm:text-sm flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <label for="password" class="block text-[#A7B3EB] mb-1 sm:mb-2 text-sm sm:text-base">
                                <i class="fas fa-lock mr-2"></i> Nueva Contraseña
                            </label>
                            <input type="password" id="password" name="password" placeholder="Dejar en blanco para no cambiar"
                                   class="w-full bg-[#0A0E2A]/70 border border-[#4A0E7B] rounded-lg px-3 py-2 sm:px-4 sm:py-3 text-white focus:border-[#FFD700] focus:ring-[#FFD700] placeholder-[#A7B3EB]/50 text-sm sm:text-base">
                            @error('password')
                            <p class="mt-1 text-red-400 text-xs sm:text-sm flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-[#A7B3EB] mb-1 sm:mb-2 text-sm sm:text-base">
                                <i class="fas fa-lock mr-2"></i> Confirmar Contraseña
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="w-full bg-[#0A0E2A]/70 border border-[#4A0E7B] rounded-lg px-3 py-2 sm:px-4 sm:py-3 text-white focus:border-[#FFD700] focus:ring-[#FFD700] placeholder-[#A7B3EB]/50 text-sm sm:text-base">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <label for="genero" class="block text-[#A7B3EB] mb-1 sm:mb-2 text-sm sm:text-base">
                                <i class="fas fa-venus-mars mr-2"></i> Género
                            </label>
                            <select id="genero" name="genero"
                                    class="w-full bg-[#0A0E2A]/70 border border-[#4A0E7B] rounded-lg px-3 py-2 sm:px-4 sm:py-3 text-white focus:border-[#FFD700] focus:ring-[#FFD700] text-sm sm:text-base">
                                <option value="">Selecciona tu género</option>
                                <option value="Masculino" {{ old('genero', $user->genero) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                <option value="Femenino" {{ old('genero', $user->genero) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                <option value="No binario" {{ old('genero', $user->genero) == 'No binario' ? 'selected' : '' }}>No binario</option>
                                <option value="Otro" {{ old('genero', $user->genero) == 'Otro' ? 'selected' : '' }}>Otro</option>
                                <option value="Prefiero no decir" {{ old('genero', $user->genero) == 'Prefiero no decir' ? 'selected' : '' }}>Prefiero no decir</option>
                            </select>
                            @error('genero')
                            <p class="mt-1 text-red-400 text-xs sm:text-sm flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div>
                            <label for="orientacion_sexual" class="block text-[#A7B3EB] mb-1 sm:mb-2 text-sm sm:text-base">
                                <i class="fas fa-heart mr-2"></i> Orientación Sexual
                            </label>
                            <select id="orientacion_sexual" name="orientacion_sexual"
                                    class="w-full bg-[#0A0E2A]/70 border border-[#4A0E7B] rounded-lg px-3 py-2 sm:px-4 sm:py-3 text-white focus:border-[#FFD700] focus:ring-[#FFD700] text-sm sm:text-base">
                                <option value="">Selecciona tu orientación</option>
                                <option value="Heterosexual" {{ old('orientacion_sexual', $user->orientacion_sexual) == 'Heterosexual' ? 'selected' : '' }}>Heterosexual</option>
                                <option value="Homosexual" {{ old('orientacion_sexual', $user->orientacion_sexual) == 'Homosexual' ? 'selected' : '' }}>Homosexual</option>
                                <option value="Bisexual" {{ old('orientacion_sexual', $user->orientacion_sexual) == 'Bisexual' ? 'selected' : '' }}>Bisexual</option>
                                <option value="Pansexual" {{ old('orientacion_sexual', $user->orientacion_sexual) == 'Pansexual' ? 'selected' : '' }}>Pansexual</option>
                                <option value="Asexual" {{ old('orientacion_sexual', $user->orientacion_sexual) == 'Asexual' ? 'selected' : '' }}>Asexual</option>
                                <option value="Prefiero no decir" {{ old('orientacion_sexual', $user->orientacion_sexual) == 'Prefiero no decir' ? 'selected' : '' }}>Prefiero no decir</option>
                            </select>
                            @error('orientacion_sexual')
                            <p class="mt-1 text-red-400 text-xs sm:text-sm flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-[#A7B3EB] mb-1 sm:mb-2 text-sm sm:text-base">
                            <i class="fas fa-map-marker-alt mr-2"></i> Ubicación
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 mb-4">
                            <div>
                                <label for="latitud" class="sr-only">Latitud</label> {{-- Accesibilidad --}}
                                <input type="text" id="latitud" name="latitud" value="{{ old('latitud', $user->latitud) }}" placeholder="Latitud" readonly {{-- Hacer readonly para que se actualice por el mapa --}}
                                       class="w-full bg-[#0A0E2A]/70 border border-[#4A0E7B] rounded-lg px-3 py-2 sm:px-4 sm:py-3 text-white focus:border-[#FFD700] focus:ring-[#FFD700] placeholder-[#A7B3EB]/50 text-sm sm:text-base">
                                @error('latitud')
                                <p class="mt-1 text-red-400 text-xs sm:text-sm flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                                @enderror
                            </div>
                            <div>
                                <label for="longitud" class="sr-only">Longitud</label> {{-- Accesibilidad --}}
                                <input type="text" id="longitud" name="longitud" value="{{ old('longitud', $user->longitud) }}" placeholder="Longitud" readonly {{-- Hacer readonly --}}
                                       class="w-full bg-[#0A0E2A]/70 border border-[#4A0E7B] rounded-lg px-3 py-2 sm:px-4 sm:py-3 text-white focus:border-[#FFD700] focus:ring-[#FFD700] placeholder-[#A7B3EB]/50 text-sm sm:text-base">
                                @error('longitud')
                                <p class="mt-1 text-red-400 text-xs sm:text-sm flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                                @enderror
                            </div>
                        </div>

                        {{-- Contenedor del mapa --}}
                        <div id="mapid" class="w-full h-80 rounded-lg border border-[#4A0E7B] shadow-md mb-4"></div>

                        <button type="button" id="get-location-btn" class="mt-2 text-[#FFD700] hover:text-white text-xs sm:text-sm flex items-center">
                            <i class="fas fa-location-arrow mr-1"></i> Usar mi ubicación actual
                        </button>
                    </div>

                    <div>
                        <label for="biografia" class="block text-[#A7B3EB] mb-1 sm:mb-2 text-sm sm:text-base">
                            <i class="fas fa-book-open mr-2"></i> Biografía
                        </label>
                        <textarea id="biografia" name="biografia" rows="3" placeholder="Cuéntanos sobre ti..."
                                  class="w-full bg-[#0A0E2A]/70 border border-[#4A0E7B] rounded-lg px-3 py-2 sm:px-4 sm:py-3 text-white focus:border-[#FFD700] focus:ring-[#FFD700] placeholder-[#A7B3EB]/50 text-sm sm:text-base">{{ old('biografia', $user->biografia) }}</textarea>
                        @error('biografia')
                        <p class="mt-1 text-red-400 text-xs sm:text-sm flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div>
                        <label for="foto_perfil" class="block text-[#A7B3EB] mb-1 sm:mb-2 text-sm sm:text-base">
                            <i class="fas fa-camera mr-2"></i> Foto de Perfil
                        </label>
                        {{-- Contenedor para la imagen de perfil actual/previsualización --}}
                        {{-- Se añaden clases para centrar y establecer un tamaño fijo para el contenedor de la imagen --}}
                        <div id="profile-image-container" class="mb-3 sm:mb-4 flex items-center justify-center p-2 rounded-full mx-auto" style="width: 150px; height: 150px;">
                            <img id="profile-preview-image"
                                 src="{{ $user->foto_perfil_url ? asset($user->foto_perfil_url) : asset('images/default-avatar.png') }}" {{-- Usa una imagen por defecto si no hay URL --}}
                                 alt="Foto de perfil actual"
                                 class="w-full h-full object-cover rounded-full border border-[#FFD700]">
                        </div>
                        <input type="file" id="foto_perfil" name="foto_perfil" accept="image/*"
                               class="w-full text-[#A7B3EB] file:mr-3 file:py-1 file:px-3 sm:file:py-2 sm:file:px-4 file:rounded-full file:border-0 file:text-xs sm:file:text-sm file:font-semibold file:bg-[#FFD700] file:text-[#0A0E2A] hover:file:bg-white">
                        @error('foto_perfil')
                        <p class="mt-1 text-red-400 text-xs sm:text-sm flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="flex flex-col sm:flex-row justify-between space-y-3 sm:space-y-0 sm:space-x-4 pt-4 sm:pt-6">
                        <a href="{{ route('astromatch') }}" class="bg-[#3A3F6D] hover:bg-[#4A4F7D] text-white font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-full transition duration-300 flex items-center justify-center text-sm sm:text-base">
                            <i class="fas fa-times mr-2"></i> Cancelar
                        </a>
                        <button type="submit" class="bg-[#FFD700] hover:bg-white text-[#0A0E2A] font-bold py-2 px-4 sm:py-3 sm:px-6 rounded-full transition duration-300 flex items-center justify-center text-sm sm:text-base">
                            <i class="fas fa-save mr-2"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Include the desktop and mobile navigation --}}
    @include('partials.desktop-nav')
    @include('partials.mobile-nav')
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lógica para la previsualización de la imagen (la que ya tienes)
        const fotoPerfilInput = document.getElementById('foto_perfil');
        const profilePreviewImage = document.getElementById('profile-preview-image');
        const profileImageContainer = document.getElementById('profile-image-container');

        if (fotoPerfilInput && profilePreviewImage) {
            fotoPerfilInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        profilePreviewImage.src = e.target.result;
                        profilePreviewImage.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    profilePreviewImage.src = "{{ $user->foto_perfil_url ? asset($user->foto_perfil_url) : asset('images/default-avatar.png') }}";
                }
            });
        }

        // --- Lógica de Leaflet.js para el mapa de ubicación ---
        const latInput = document.getElementById('latitud');
        const lonInput = document.getElementById('longitud');
        const getLocationBtn = document.getElementById('get-location-btn');

        // Coordenadas por defecto (ej. Caracas, Venezuela si no hay datos del usuario)
        const defaultLat = {{ $user->latitud ?: '10.4806' }}; // Latitud de Caracas
        const defaultLon = {{ $user->longitud ?: '-66.9036' }}; // Longitud de Caracas
        const defaultZoom = 13; // Zoom inicial

        // Inicializar el mapa
        const map = L.map('mapid').setView([defaultLat, defaultLon], defaultZoom);

        // Añadir la capa de azulejos de OpenStreetMap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        let marker; // Variable para almacenar el marcador

        // Función para añadir/actualizar el marcador
        function updateMarker(lat, lon) {
            if (marker) {
                marker.setLatLng([lat, lon]);
            } else {
                marker = L.marker([lat, lon], { draggable: true }).addTo(map);
                marker.on('dragend', function(e) {
                    const newLatLng = marker.getLatLng();
                    latInput.value = newLatLng.lat.toFixed(6);
                    lonInput.value = newLatLng.lng.toFixed(6);
                });
            }
            map.setView([lat, lon], map.getZoom() || defaultZoom); // Centrar el mapa en el marcador
            latInput.value = lat.toFixed(6);
            lonInput.value = lon.toFixed(6);
        }

        // Si el usuario ya tiene latitud/longitud guardadas, las usamos para el mapa inicial
        if (latInput.value && lonInput.value) {
            updateMarker(parseFloat(latInput.value), parseFloat(lonInput.value));
        }

        // Event listener para el botón "Usar mi ubicación actual"
        getLocationBtn.addEventListener('click', function() {
            getLocationBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Detectando...';
            getLocationBtn.disabled = true;

            if (navigator.geolocation) {
                map.locate({ setView: true, maxZoom: 16 }); // Intentar geolocalizar y centrar el mapa
            } else {
                alert('La geolocalización no es soportada por tu navegador.');
                getLocationBtn.innerHTML = '<i class="fas fa-location-arrow mr-1"></i> Usar mi ubicación actual';
                getLocationBtn.disabled = false;
            }
        });

        // Eventos de Leaflet para la geolocalización
        map.on('locationfound', function(e) {
            const lat = e.latitude;
            const lon = e.longitude;
            updateMarker(lat, lon); // Actualiza el marcador y los campos de input
            getLocationBtn.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Ubicación obtenida';
            setTimeout(() => {
                getLocationBtn.innerHTML = '<i class="fas fa-location-arrow mr-1"></i> Usar mi ubicación actual';
                getLocationBtn.disabled = false;
            }, 2000);
        });

        map.on('locationerror', function(e) {
            let errorMsg = 'No se pudo obtener la ubicación: ' + e.message;
            if (e.code === 1) { // PERMISSION_DENIED
                errorMsg = 'Permiso denegado. Por favor habilita la geolocalización en la configuración de tu navegador.';
            }
            alert(errorMsg);
            getLocationBtn.innerHTML = '<i class="fas fa-location-arrow mr-1"></i> Usar mi ubicación actual';
            getLocationBtn.disabled = false;
        });

        // Opcional: Evento para actualizar lat/lon si el usuario arrastra el mapa (no solo el marcador)
        // map.on('moveend', function() {
        //     if (marker) {
        //         const center = map.getCenter();
        //         marker.setLatLng(center);
        //         latInput.value = center.lat.toFixed(6);
        //         lonInput.value = center.lng.toFixed(6);
        //     }
        // });
    });
</script>

<style>
    /* Asegurar que el contenido no quede detrás de los menús fijos */
    @media (max-width: 640px) {
        body {
            padding-bottom: 72px; /* Altura de la barra de navegación móvil */
        }
    }
    @media (min-width: 641px) {
        body {
            padding-bottom: 64px; /* Altura del menú fijo desktop */
        }
    }

    /* Efecto de brillo para los iconos activos */
    .text-[#FFD700] {
        filter: drop-shadow(0 0 4px rgba(255, 215, 0, 0.4));
    }

    /* Animación para los inputs al enfocar */
    input:focus, textarea:focus, select:focus {
        box-shadow: 0 0 0 2px rgba(255, 215, 0, 0.3);
        transition: all 0.2s ease;
    }

    /* Estilo para el botón de ubicación */
    #get-location-btn:hover {
        transform: translateY(-1px);
    }

    /* Mejoras para dispositivos muy pequeños */
    @media (max-width: 360px) {
        .file\:px-3 {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }
        .file\:text-xs {
            font-size: 0.65rem;
        }
    }
</style>
@endsection