@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-br from-[#1e3a8a] via-[#3b82f6] to-[#9333ea] text-white min-h-screen py-8 px-4 sm:px-6 lg:px-8 flex items-center justify-center relative overflow-hidden">
    <!-- Elementos decorativos de fondo -->
    <div class="absolute inset-0 overflow-hidden -z-10">
        <div class="absolute top-10 left-1/4 w-1 h-1 bg-white rounded-full opacity-70"></div>
        <div class="absolute top-20 right-1/4 w-1 h-1 bg-white rounded-full opacity-70"></div>
        <div class="absolute bottom-1/3 left-1/3 w-1 h-1 bg-white rounded-full opacity-70"></div>
        <div class="absolute top-1/2 right-1/2 w-1 h-1 bg-white rounded-full opacity-70"></div>
        <div class="absolute bottom-20 left-20 w-1 h-1 bg-white rounded-full opacity-70"></div>
        <div class="absolute top-32 right-32 w-1 h-1 bg-white rounded-full opacity-70"></div>
    </div>

    <div class="absolute top-0 left-0 w-64 h-64 bg-[#4A0E7B] rounded-full mix-blend-screen opacity-10 blur-3xl animate-blob -z-10"></div>
    <div class="absolute bottom-0 right-0 w-64 h-64 bg-[#8A2BE2] rounded-full mix-blend-screen opacity-10 blur-3xl animate-blob animation-delay-2000 -z-10"></div>
    <div class="absolute top-1/4 left-1/4 w-40 h-40 bg-[#FFD700] rounded-full mix-blend-screen opacity-5 blur-3xl animate-blob animation-delay-4000 -z-10"></div>

    <div class="max-w-4xl w-full mx-auto relative z-10 animate-fade-in">
        <!-- Contenedor principal del formulario -->
        <div class="bg-[#0A0E2A] rounded-2xl p-6 sm:p-8 shadow-2xl border border-[#4A0E7B]">
            <!-- Animación Lottie -->
            <div id="lottieAnim" class="w-28 h-28 mx-auto mb-2"></div>

            <!-- Encabezado -->
            <div class="text-center mb-6">
                <h1 class="text-2xl md:text-3xl font-bold text-[#FFD700] mb-2">
                    <i class="fas fa-star mr-2"></i>Compatibilidad Astrológica
                </h1>
                <p class="text-lg italic mb-3 text-[#E0E7FF]">Solo responde estas 5 preguntas para descubrir quién vibra contigo...</p>
                <h2 class="text-2xl md:text-3xl font-bold text-white">
                    Completa tu perfil básico
                </h2>
            </div>

            <form action="{{ route('usuarios_compatibles') }}" method="GET" class="space-y-6 text-left">
                <!-- SIGNO ZODIACAL -->
                <div>
                    <label class="block mb-3 font-semibold text-center text-white text-lg">
                        <span class="inline-flex items-center">
                            <i class="fas fa-sun text-[#FFD700] mr-2"></i>
                            <span>Selecciona tu signo zodiacal</span>
                        </span>
                    </label>
                    <div class="grid grid-cols-3 sm:grid-cols-4 gap-3 text-sm">
                        @php
                            $signos = [
                                'Aries' => 'Aries.png',
                                'Tauro' => 'Tauro.png',
                                'Géminis' => 'Géminis.png',
                                'Cáncer' => 'Cáncer.png',
                                'Leo' => 'Leo.png',
                                'Virgo' => 'Virgo.png',
                                'Libra' => 'Libra.png',
                                'Escorpio' => 'Escorpio.png',
                                'Sagitario' => 'Sagitario.png',
                                'Capricornio' => 'Capricornio.png',
                                'Acuario' => 'Acuario.png',
                                'Piscis' => 'Piscis.png',
                            ];
                        @endphp
                        @foreach($signos as $signo => $icono)
                            <label class="cursor-pointer">
                                <input type="radio" name="signo" value="{{ $signo }}" class="hidden peer" required>
                                <div class="bg-[#1A1F3D] p-3 rounded-xl border border-[#4A0E7B] transition-all peer-checked:border-[#FFD700] peer-checked:ring-1 peer-checked:ring-[#FFD700]/50">
                                    <img src="{{ asset('images/zodiaco/' . $icono) }}" class="w-10 h-10 mx-auto mb-1" alt="{{ $signo }}">
                                    <div class="text-center font-medium text-white">{{ $signo }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- GÉNERO -->
                <div>
                    <label class="block mb-3 font-semibold text-center text-white text-lg">
                        <span class="inline-flex items-center">
                            <i class="fas fa-user text-[#3b82f6] mr-2"></i>
                            <span>Selecciona tu género</span>
                        </span>
                    </label>
                    <div class="flex justify-center gap-3 sm:gap-4 flex-wrap">
                        @php
                            $generos = [
                                'masculino' => ['businessman.png', 'Masculino'],
                                'femenino' => ['woman.png', 'Femenino'],
                            ];
                        @endphp
                        @foreach($generos as $valor => [$icono, $texto])
                            <label class="cursor-pointer flex-1 min-w-[120px] max-w-[140px]">
                                <input type="radio" name="genero" value="{{ $valor }}" class="hidden peer" required>
                                <div class="bg-[#1A1F3D] p-3 rounded-xl border border-[#4A0E7B] transition-all peer-checked:border-[#3b82f6] peer-checked:ring-1 peer-checked:ring-[#3b82f6]/50">
                                    <img src="{{ asset('images/otros/' . $icono) }}" class="w-10 h-10 mx-auto mb-1" alt="{{ $texto }}">
                                    <div class="text-center font-medium text-white">{{ $texto }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- ORIENTACIÓN SEXUAL -->
                <div>
                    <label class="block mb-3 font-semibold text-center text-white text-lg">
                        <span class="inline-flex items-center">
                            <i class="fas fa-heart text-[#ec4899] mr-2"></i>
                            <span>Tu orientación sexual</span>
                        </span>
                    </label>
                    <div class="flex justify-center gap-3 sm:gap-4 flex-wrap">
                        @php
                            $orientaciones = [
                                'heterosexual' => ['sexual.png', 'Heterosexual'],
                                'homosexual' => ['inclusive.png', 'Homosexual'],
                                'bisexual' => ['bisexual.png', 'Bisexual'],
                            ];
                        @endphp
                        @foreach($orientaciones as $valor => [$icono, $texto])
                            <label class="cursor-pointer flex-1 min-w-[100px] max-w-[120px]">
                                <input type="radio" name="orientacion" value="{{ $valor }}" class="hidden peer" required>
                                <div class="bg-[#1A1F3D] p-3 rounded-xl border border-[#4A0E7B] transition-all peer-checked:border-[#ec4899] peer-checked:ring-1 peer-checked:ring-[#ec4899]/50">
                                    <img src="{{ asset('images/otros/' . $icono) }}" class="w-10 h-10 mx-auto mb-1" alt="{{ $texto }}">
                                    <div class="text-center font-medium text-white">{{ $texto }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- BUSCA -->
                <div>
                    <label class="block mb-3 font-semibold text-center text-white text-lg">
                        <span class="inline-flex items-center">
                            <i class="fas fa-search text-[#10b981] mr-2"></i>
                            <span>¿A quién estás buscando?</span>
                        </span>
                    </label>
                    <div class="flex justify-center gap-3 sm:gap-4 flex-wrap">
                        @php
                            $buscas = [
                                'hombres' => ['businessman.png', 'Hombres'],
                                'mujeres' => ['woman.png', 'Mujeres'],
                                'ambos' => ['sexual.png', 'Ambos']
                            ];
                        @endphp
                        @foreach($buscas as $valor => [$icono, $texto])
                            <label class="cursor-pointer flex-1 min-w-[100px] max-w-[120px]">
                                <input type="radio" name="busca" value="{{ $valor }}" class="hidden peer" required>
                                <div class="bg-[#1A1F3D] p-3 rounded-xl border border-[#4A0E7B] transition-all peer-checked:border-[#10b981] peer-checked:ring-1 peer-checked:ring-[#10b981]/50">
                                    <img src="{{ asset('images/otros/' . $icono) }}" class="w-10 h-10 mx-auto mb-1" alt="{{ $texto }}">
                                    <div class="text-center font-medium text-white">{{ $texto }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- EDAD -->
                <div class="text-center">
                    <label class="block mb-3 font-semibold text-center text-white text-lg">
                        <span class="inline-flex items-center">
                            <i class="fas fa-calendar-alt text-[#f59e0b] mr-2"></i>
                            <span>Tu edad</span>
                        </span>
                    </label>
                    <div class="flex flex-col items-center">
                        <div class="inline-flex items-center justify-center bg-[#1A1F3D] rounded-xl px-6 py-3 border border-[#4A0E7B]">
                            <button type="button"
                                    onclick="cambiarEdad(-1)"
                                    class="text-2xl font-bold px-4 py-1 rounded-lg bg-[#0A0E2A] hover:bg-[#1e3a8a] text-white disabled:opacity-40 transition-colors"
                                    id="btnMenos">
                                −
                            </button>

                            <input type="number" name="edad" id="edadInput"
                                   value="25" min="18" max="100"
                                   class="w-20 text-center bg-white font-bold rounded-lg px-3 py-2 text-xl mx-3 text-[#0A0E2A]"
                                   readonly>

                            <button type="button"
                                    onclick="cambiarEdad(1)"
                                    class="text-2xl font-bold px-4 py-1 rounded-lg bg-[#0A0E2A] hover:bg-[#1e3a8a] text-white disabled:opacity-40 transition-colors"
                                    id="btnMas">
                                +
                            </button>
                        </div>
                        <p class="text-sm text-[#E0E7FF]/70 mt-2">Edad entre 18 y 100 años</p>
                    </div>
                </div>

                <!-- BOTÓN -->
                <div class="text-center pt-4">
                    <button type="submit" 
                            class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-[#FFD700] to-[#F8C800] text-[#0A0E2A] font-bold rounded-full transition-all duration-300 hover:shadow-lg hover:shadow-[#FFD700]/30">
                        <i class="fas fa-rocket mr-2"></i> Ver personas compatibles
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script de Lottie y función JS -->
    <script>
        // Carga la animación Lottie cuando el DOM esté listo
        document.addEventListener('DOMContentLoaded', function() {
            lottie.loadAnimation({
                container: document.getElementById('lottieAnim'),
                renderer: 'svg',
                loop: true,
                autoplay: true,
                
            });
        });

        // Función para cambiar la edad con los botones
        function cambiarEdad(delta) {
            const input = document.getElementById('edadInput');
            let valor = parseInt(input.value) || 25;
            valor += delta;

            // Limitar entre 18 y 100
            valor = Math.min(Math.max(valor, 18), 100);
            input.value = valor;

            // Deshabilitar botones si se alcanzan los límites
            document.getElementById('btnMenos').disabled = valor <= 18;
            document.getElementById('btnMas').disabled = valor >= 100;
        }

        // Inicializar estado de botones
        document.addEventListener('DOMContentLoaded', function() {
            cambiarEdad(0); // Para inicializar el estado de los botones
        });
    </script>
</section>

<style>
    /* Animaciones personalizadas */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    
    .animate-fade-in {
        animation: fadeIn 0.8s ease-out forwards;
    }
    
    .animate-blob {
        animation: blob 15s infinite ease-in-out;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animation-delay-4000 {
        animation-delay: 4s;
    }
</style>
@endsection