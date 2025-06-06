<div class="bg-gradient-to-r from-[#4A0E7B] to-[#1A1F4D] rounded-2xl p-6 md:p-8 mb-6 shadow-lg relative overflow-hidden">
    {{-- Efectos de fondo --}}
    <div class="absolute -top-10 -right-10 w-32 h-32 bg-[#FFD700] bg-opacity-10 rounded-full"></div>
    <div class="absolute -bottom-20 -left-10 w-40 h-40 bg-[#FFD700] bg-opacity-5 rounded-full"></div>

    {{-- Contenedor principal del contenido de la tarjeta --}}
    <div class="relative z-10 flex flex-col md:flex-row items-center md:items-start w-full">

        {{-- Columna Izquierda: Ícono de Perfil (Astronauta) --}}
        <div class="flex-shrink-0 mb-6 md:mb-0 md:mr-6">
            <div class="w-48 h-48 sm:w-60 sm:h-60 rounded-full bg-[#0A0E2A] border-2 border-[#FFD700] flex items-center justify-center">
                @if($user->foto_perfil_url)
                    {{-- Si hay foto de perfil, la mostrará --}}
                    <img src="{{ asset($user->foto_perfil_url) }}" alt="Foto de Perfil" class="w-full h-full object-cover rounded-full">
                @else
                    {{-- De lo contrario, muestra el icono del astronauta --}}
                    <i class="fas fa-user-astronaut text-7xl sm:text-8xl text-[#FFD700]"></i>
                @endif
            </div>
        </div>

        {{-- Columna Derecha: Nombre, Progreso, Signo, Elemento, Modalidad --}}
        <div class="flex-grow text-center md:text-left">

            {{-- Sección del Medio: Nombre de Usuario y Progreso --}}
            <div class="mb-4"> {{-- Margin-bottom para separar de la info de signo --}}
                <h3 class="text-2xl sm:text-3xl font-bold mb-2">
                    @if(isset($user)) {{ $user->nombre_completo }} @else Tu Perfil Astral @endif
                </h3>
                @php
                    $profileCompletion = isset($user) ? $user->profile_completion_percentage : 0;
                @endphp
                <p class="text-[#A7B3EB] text-base mb-3">
                    Perfil Completado: {{ $profileCompletion }}%
                </p>
                <div class="w-full max-w-md bg-[#0A0E2A] bg-opacity-50 rounded-full h-3">
                    <div class="bg-[#FFD700] h-3 rounded-full" style="width: {{ $profileCompletion }}%"></div>
                </div>
            </div>

            {{-- Sección de Abajo: Signo, Elemento y Modalidad (Horizontal) --}}
            @if(isset($user->datosAstralesBasicos->signoSolar))
                <div class="flex flex-col sm:flex-row items-center md:items-start justify-center md:justify-start space-y-4 sm:space-y-0 sm:space-x-6 md:space-x-8 mt-6 md:mt-8">

                    {{-- Columna 1: Signo Solar (Imagen y Nombre) --}}
                    <div class="flex flex-col items-center text-center">
                        {{-- Imagen del Signo Solar (Circular) --}}
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-[#0A0E2A] border-2 border-[#FFD700] flex items-center justify-center mb-2">
                            <?php
                                $signoSlug = strtolower($user->datosAstralesBasicos->signoSolar->nombre_signo);
                            ?>
                            <img src="{{ asset('images/zodiaco/' . $signoSlug . '.png') }}" alt="{{ $user->datosAstralesBasicos->signoSolar->nombre_signo }}" class="w-full h-full object-contain p-1">
                        </div>
                        <h4 class="text-base sm:text-lg font-bold text-[#FFD700]">
                            {{ $user->datosAstralesBasicos->signoSolar->nombre_signo }}
                        </h4>
                    </div>

                    {{-- Columna 2: Elemento (Icono y Nombre del Elemento) --}}
                    @php
                        $elemento = $user->datosAstralesBasicos->signoSolar->elemento;
                        $iconoElemento = '';
                        $colorElemento = 'text-white';

                        switch ($elemento) {
                            case 'Fuego':
                                $iconoElemento = 'fa-fire';
                                $colorElemento = 'text-orange-400';
                                break;
                            case 'Tierra':
                                $iconoElemento = 'fa-leaf';
                                $colorElemento = 'text-green-400';
                                break;
                            case 'Aire':
                                $iconoElemento = 'fa-wind';
                                $colorElemento = 'text-blue-400';
                                break;
                            case 'Agua':
                                $iconoElemento = 'fa-water';
                                $colorElemento = 'text-sky-400';
                                break;
                        }
                    @endphp
                    <div class="flex flex-col items-center text-center">
                        {{-- Icono del Elemento (Circular) --}}
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-[#0A0E2A] border-2 border-[#FFD700] flex items-center justify-center mb-2">
                            <i class="fas {{ $iconoElemento }} {{ $colorElemento }} text-3xl sm:text-4xl"></i>
                        </div>
                        {{-- Muestra el nombre del elemento con el estilo del signo --}}
                        <p class="text-base sm:text-lg font-bold text-[#FFD700]">{{ $elemento }}</p>
                    </div>

                    {{-- Columna 3: Modalidad (Icono y Nombre de la Modalidad) --}}
                    @php
                        $modalidad = $user->datosAstralesBasicos->signoSolar->modalidad;
                        $iconoModalidad = '';
                        $colorModalidad = 'text-white';

                        switch ($modalidad) {
                            case 'Cardinal':
                                $iconoModalidad = 'fa-compass';
                                $colorModalidad = 'text-red-400';
                                break;
                            case 'Fijo':
                                $iconoModalidad = 'fa-anchor';
                                $colorModalidad = 'text-gray-400';
                                break;
                            case 'Mutable':
                                $iconoModalidad = 'fa-sync-alt';
                                $colorModalidad = 'text-purple-400';
                                break;
                            default:
                                $iconoModalidad = 'fa-circle';
                                $colorModalidad = 'text-white';
                                break;
                        }
                    @endphp
                    <div class="flex flex-col items-center text-center">
                        {{-- Icono para Modalidad (Circular) --}}
                        <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-[#0A0E2A] border-2 border-[#FFD700] flex items-center justify-center mb-2">
                            <i class="fas {{ $iconoModalidad }} {{ $colorModalidad }} text-3xl sm:text-4xl"></i>
                        </div>
                        {{-- Muestra el nombre de la modalidad con el estilo del signo --}}
                        <p class="text-base sm:text-lg font-bold text-[#FFD700]">{{ $modalidad }}</p>
                    </div>

                </div>
            @else
                <p class="text-[#A7B3EB] text-base text-center md:text-left mt-6 md:mt-8">Calculando Signo Solar...</p>
            @endif
        </div>

        {{-- Botón para calcular datos astrales con IA (Derecha del todo, posición absoluta) --}}
        {{-- CAMBIADO DE <a> A <button> y añadido ID --}}
        <button id="calculateGroqAstrology" class="absolute top-6 right-6 text-[#FFD700] hover:text-white transition-colors duration-200 p-2 rounded-full focus:outline-none focus:ring-2 focus:ring-[#FFD700]">
            <i class="fas fa-magic text-2xl sm:text-3xl"></i> {{-- Icono de magia o estrella para la IA --}}
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calculateButton = document.getElementById('calculateGroqAstrology');

        if (calculateButton) {
            calculateButton.addEventListener('click', function(event) {
                event.preventDefault(); // Previene el comportamiento por defecto del botón/enlace

                // Recolectar los datos del usuario (desde el objeto Blade $user)
                const userData = {
                    nombre_completo: "{{ $user->nombre_completo ?? 'Usuario Desconocido' }}",
                    fecha_nacimiento: "{{ $user->fecha_nacimiento ?? '' }}",
                    hora_nacimiento: "{{ $user->hora_nacimiento ?? '' }}",
                    lugar_nacimiento: "{{ $user->lugar_nacimiento ?? '' }}",
                    genero: "{{ $user->genero ?? '' }}"
                };

                // Opcional: Mostrar un indicador de carga
                calculateButton.innerHTML = '<i class="fas fa-spinner fa-spin text-2xl sm:text-3xl"></i>';
                calculateButton.disabled = true;

                // Enviar los datos al backend usando Fetch API
                fetch("{{ route('groq.calculate-astrology') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Token CSRF para seguridad en Laravel
                    },
                    body: JSON.stringify(userData)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // Redirigir a la página de resultados con los datos de la IA
                    // Podrías pasar los datos a la URL como parámetros (cuidado con el tamaño)
                    // O, más seguro, guardarlos en localStorage y que la nueva página los lea
                    localStorage.setItem('groqResponse', JSON.stringify(data));
                    window.location.href = "{{ route('groq.show-response') }}";
                })
                .catch(error => {
                    console.error('Error al enviar datos a Groq API:', error);
                    alert('Hubo un error al calcular los datos astrales con la IA. Consulta la consola.');
                    calculateButton.innerHTML = '<i class="fas fa-magic text-2xl sm:text-3xl"></i>';
                    calculateButton.disabled = false;
                });
            });
        }
    });
</script>