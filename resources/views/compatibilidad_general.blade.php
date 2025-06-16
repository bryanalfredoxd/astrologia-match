@extends('layouts.app')

@section('content')
<section class="bg-[#0A0E2A] text-white min-h-screen py-10 px-4 sm:px-6 flex items-center justify-center relative overflow-hidden">

    <div class="max-w-7xl mx-auto text-center relative z-10">
        {{-- Contenedor principal del formulario, adaptado al estilo de carta_astral.blade.php --}}
        <div class="bg-white bg-opacity-10 p-8 rounded-2xl backdrop-blur-md shadow-xl w-full max-w-3xl mx-auto text-center border border-[#4A0E7B] border-opacity-40">

            <!-- Animación Lottie - Mantener la misma ID para el script -->
            <div id="lottieAnim" class="w-28 h-28 mx-auto mb-4"></div>

            <!-- Frase -->
            <p class="text-lg italic mb-2 text-[#A7B3EB]">Solo responde estas 5 preguntas para descubrir quién vibra contigo...</p>
            <h1 class="text-3xl font-bold mb-6 text-[#FFD700]">Completa tu perfil básico</h1>

            <form action="{{ route('usuarios_compatibles') }}" method="GET" class="space-y-8 text-left">

                <!-- SIGNO ZODIACAL -->
                <div>
                    <label class="block mb-2 font-semibold text-center text-white"><i class="fa-solid fa-star text-yellow-300 mr-1"></i>Selecciona tu signo zodiacal</label>
                    <div class="grid grid-cols-4 gap-3 text-sm text-white">
                        @php
                            $signos = [
                                'Aries' => '♈','Tauro' => '♉','Géminis' => '♊','Cáncer' => '♋',
                                'Leo' => '♌','Virgo' => '♍','Libra' => '♎','Escorpio' => '♏',
                                'Sagitario' => '♐','Capricornio' => '♑','Acuario' => '♒','Piscis' => '♓',
                            ];
                        @endphp
                        @foreach($signos as $signo => $icono)
                            <label class="cursor-pointer bg-white bg-opacity-10 p-2 rounded-lg hover:bg-opacity-20 text-center">
                                <input type="radio" name="signo" value="{{ $signo }}" class="hidden peer" required>
                                <div class="peer-checked:ring-2 ring-yellow-300 rounded-lg p-1">
                                    <div class="text-2xl mb-1">{{ $icono }}</div>
                                    <div class="font-medium">{{ $signo }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- GÉNERO -->
                <div>
                    <label class="block mb-2 font-semibold text-center text-white"><i class="fa-solid fa-user text-blue-300 mr-1"></i>Selecciona tu género</label>
                    <div class="flex justify-center gap-6 text-white text-sm">
                        @php
                            $generos = [
                                'masculino' => ['👨', 'Masculino'],
                                'femenino' => ['👩', 'Femenino'],
                                'otro' => ['⚧️', 'Otro']
                            ];
                        @endphp
                        @foreach($generos as $valor => [$icono, $texto])
                            <label class="cursor-pointer bg-white bg-opacity-10 px-4 py-3 rounded-xl hover:bg-opacity-20 text-center">
                                <input type="radio" name="genero" value="{{ $valor }}" class="hidden peer" required>
                                <div class="peer-checked:ring-2 ring-blue-400 rounded-lg p-1">
                                    <div class="text-2xl">{{ $icono }}</div>
                                    <div class="font-medium">{{ $texto }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- ORIENTACIÓN SEXUAL -->
                <div>
                    <label class="block mb-2 font-semibold text-center text-white"><i class="fa-solid fa-heart text-pink-400 mr-1"></i>Tu orientación sexual</label>
                    <div class="flex justify-center gap-4 text-white text-sm flex-wrap">
                        @php
                            $orientaciones = [
                                'heterosexual' => ['❤️', 'Heterosexual'],
                                'homosexual' => ['🏳️‍🌈', 'Homosexual'],
                                'bisexual' => ['💖💙', 'Bisexual'],
                                'otro' => ['✨', 'Otro']
                            ];
                        @endphp
                        @foreach($orientaciones as $valor => [$icono, $texto])
                            <label class="cursor-pointer bg-white bg-opacity-10 px-4 py-3 rounded-xl hover:bg-opacity-20 text-center">
                                <input type="radio" name="orientacion" value="{{ $valor }}" class="hidden peer" required>
                                <div class="peer-checked:ring-2 ring-pink-300 rounded-lg p-1">
                                    <div class="text-lg">{{ $icono }}</div>
                                    <div class="font-medium">{{ $texto }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- BUSCA -->
                <div>
                    <label class="block mb-2 font-semibold text-center text-white"><i class="fa-solid fa-magnifying-glass text-green-300 mr-1"></i>¿A quién estás buscando?</label>
                    <div class="flex justify-center gap-6 text-white text-sm">
                        @php
                            $buscas = [
                                'hombres' => ['👨', 'Hombres'],
                                'mujeres' => ['👩', 'Mujeres'],
                                'ambos' => ['⚧️', 'Ambos']
                            ];
                        @endphp
                        @foreach($buscas as $valor => [$icono, $texto])
                            <label class="cursor-pointer bg-white bg-opacity-10 px-4 py-3 rounded-xl hover:bg-opacity-20 text-center">
                                <input type="radio" name="busca" value="{{ $valor }}" class="hidden peer" required>
                                <div class="peer-checked:ring-2 ring-green-300 rounded-lg p-1">
                                    <div class="text-2xl">{{ $icono }}</div>
                                    <div class="font-medium">{{ $texto }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- EDAD MEJORADA -->
                <div class="text-center">
                    <label class="block mb-2 font-semibold text-center text-white"><i class="fa-solid fa-calendar text-orange-300 mr-1"></i>Tu edad</label>
                    <div class="inline-flex items-center justify-center bg-white bg-opacity-10 rounded-full px-4 py-2 shadow-inner space-x-4">
                        <button type="button"
                                onclick="cambiarEdad(-1)"
                                class="text-xl font-bold px-3 py-1 rounded-full bg-white bg-opacity-20 hover:bg-opacity-30 text-white disabled:opacity-40"
                                id="btnMenos">
                            −
                        </button>

                        <input type="number" name="edad" id="edadInput"
                               value="18" min="18" max="100"
                               class="w-16 text-center text-black font-bold rounded px-2 py-1 text-lg"
                               readonly>

                        <button type="button"
                                onclick="cambiarEdad(1)"
                                class="text-xl font-bold px-3 py-1 rounded-full bg-white bg-opacity-20 hover:bg-opacity-30 text-white disabled:opacity-40"
                                id="btnMas">
                            +
                        </button>
                    </div>
                    <p class="text-sm text-white/70 mt-2">Edad entre 18 y 100 años</p>
                </div>

                <!-- BOTÓN -->
                <div class="text-center mt-6">
                    <button type="submit" class="bg-white text-indigo-700 font-semibold px-6 py-3 rounded-full hover:bg-indigo-100 transition-all">
                        🔮 Ver personas compatibles
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
                path: 'https://assets1.lottiefiles.com/packages/lf20_ghs9bgtu.json' // Asegúrate de que esta ruta sea correcta
            });
        });

        // Función para cambiar la edad con los botones
        function cambiarEdad(delta) {
            const input = document.getElementById('edadInput');
            let valor = parseInt(input.value) || 18; // Asegura un valor inicial si no es un número
            valor += delta;

            if (valor < 18) valor = 18; // Edad mínima
            if (valor > 100) valor = 100; // Edad máxima

            input.value = valor;
        }
    </script>

    <!-- Elementos decorativos de fondo (copia de carta_astral.blade.php para consistencia) -->
    <div class="absolute top-0 left-0 w-48 h-48 bg-[#4A0E7B] rounded-full mix-blend-screen opacity-10 blur-3xl animate-blob -z-10"></div>
    <div class="absolute bottom-0 right-0 w-48 h-48 bg-[#8A2BE2] rounded-full mix-blend-screen opacity-10 blur-3xl animate-blob animation-delay-2000 -z-10"></div>
    <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-[#FFD700] rounded-full mix-blend-screen opacity-5 blur-3xl animate-blob animation-delay-4000 -z-10"></div>
</section>
@endsection