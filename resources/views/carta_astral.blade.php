@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-br from-[#1e3a8a] via-[#3b82f6] to-[#9333ea] text-white min-h-screen py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    <!-- Patrón de estrellas decorativo -->
    <div class="absolute inset-0 overflow-hidden -z-10">
        <div class="absolute top-10 left-1/4 w-1 h-1 bg-white rounded-full opacity-70"></div>
        <div class="absolute top-20 right-1/4 w-1 h-1 bg-white rounded-full opacity-70"></div>
        <div class="absolute bottom-1/3 left-1/3 w-1 h-1 bg-white rounded-full opacity-70"></div>
        <div class="absolute top-1/2 right-1/2 w-1 h-1 bg-white rounded-full opacity-70"></div>
        <div class="absolute bottom-20 left-20 w-1 h-1 bg-white rounded-full opacity-70"></div>
        <div class="absolute top-32 right-32 w-1 h-1 bg-white rounded-full opacity-70"></div>
    </div>

    <!-- Elementos decorativos de fondo -->
    <div class="absolute top-0 left-0 w-64 h-64 bg-[#4A0E7B] rounded-full mix-blend-screen opacity-10 blur-3xl animate-blob -z-10"></div>
    <div class="absolute bottom-0 right-0 w-64 h-64 bg-[#8A2BE2] rounded-full mix-blend-screen opacity-10 blur-3xl animate-blob animation-delay-2000 -z-10"></div>
    <div class="absolute top-1/4 left-1/4 w-40 h-40 bg-[#FFD700] rounded-full mix-blend-screen opacity-5 blur-3xl animate-blob animation-delay-4000 -z-10"></div>

    <div class="max-w-7xl mx-auto text-center relative z-10">
        <!-- Encabezado principal -->
        <div class="mb-12 animate-fade-in">
            <div class="inline-block bg-white bg-opacity-10 backdrop-blur-sm rounded-full px-6 py-2 mb-6 border border-[#4A0E7B] border-opacity-30">
                <span class="text-[#FFD700] font-medium"><i class="fas fa-star mr-2 text-[#FFD700]"></i>Astrología Profesional</span>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 text-white bg-clip-text bg-gradient-to-r from-[#FFD700] via-[#FFFFFF] to-[#A7B3EB] text-transparent">
                Tu Carta Astral Personalizada
            </h1>
            <p class="text-lg md:text-xl lg:text-2xl mb-8 leading-relaxed max-w-4xl mx-auto text-[#E0E7FF]">
                Descubre los secretos del cielo en el momento exacto de tu nacimiento y cómo influyen en tu personalidad, emociones y relaciones.
            </p>
        </div>

        <!-- Sección de introducción -->
        <div class="flex justify-center mb-16 animate-fade-in-up">
            <div class="bg-[#0A0E2A]/50 rounded-2xl p-8 backdrop-blur-sm shadow-2xl max-w-4xl text-center border border-[#4A0E7B] border-opacity-40 transform transition hover:scale-[1.01]">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-[#FFD700] bg-opacity-20 rounded-full mb-4 border border-[#FFD700] border-opacity-30">
                    <i class="fas fa-globe-americas text-2xl text-[#FFD700]"></i>
                </div>
                <p class="text-lg md:text-xl leading-relaxed text-[#E0E7FF]">
                    La carta astral es un <span class="font-semibold text-white">mapa celeste único</span> que captura la posición exacta de los planetas, el Sol y la Luna en el momento de tu nacimiento. Revela tus <span class="font-semibold text-white">tendencias naturales</span>, <span class="font-semibold text-white">potenciales</span> y <span class="font-semibold text-white">desafíos</span> a través de tres componentes clave:
                </p>
            </div>
        </div>

        <!-- LOS TRES SIGNOS - Grid responsive -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16 animate-fade-in-up">
            <!-- Signo Solar -->
            <div class="group bg-[#0A0E2A]/50 p-6 rounded-2xl shadow-xl backdrop-blur-sm hover:scale-[1.02] transition-all duration-300 border border-[#4A0E7B] border-opacity-40 hover:border-[#FFD700]/30">
                <div class="flex flex-col items-center mb-6">
                    <div class="w-20 h-20 bg-[#FFD700]/10 rounded-full flex items-center justify-center mb-4 border border-[#FFD700]/30 group-hover:bg-[#FFD700]/20 transition-colors">
                        <i class="fas fa-sun text-3xl text-[#FFD700]"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white text-center">Signo Solar</h3>
                    <div class="w-16 h-1 bg-[#FFD700] mt-2 rounded-full"></div>
                </div>
                <p class="text-[#E0E7FF] leading-relaxed">
                    Representa tu <span class="font-semibold text-white">esencia vital</span> y cómo te proyectas al mundo. Es la energía que te impulsa y tu identidad central.
                    <br><br>
                    <span class="block bg-[#1e3a8a]/30 p-3 rounded-lg mt-4 border-l-4 border-[#FFD700]">
                        <span class="font-semibold text-[#FFD700]">Dato necesario:</span> Fecha exacta de nacimiento
                    </span>
                </p>
            </div>

            <!-- Signo Lunar -->
            <div class="group bg-[#0A0E2A]/50 p-6 rounded-2xl shadow-xl backdrop-blur-sm hover:scale-[1.02] transition-all duration-300 border border-[#4A0E7B] border-opacity-40 hover:border-[#A7B3EB]/30">
                <div class="flex flex-col items-center mb-6">
                    <div class="w-20 h-20 bg-[#A7B3EB]/10 rounded-full flex items-center justify-center mb-4 border border-[#A7B3EB]/30 group-hover:bg-[#A7B3EB]/20 transition-colors">
                        <i class="fas fa-moon text-3xl text-[#A7B3EB]"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white text-center">Signo Lunar</h3>
                    <div class="w-16 h-1 bg-[#A7B3EB] mt-2 rounded-full"></div>
                </div>
                <p class="text-[#E0E7FF] leading-relaxed">
                    Revela tu <span class="font-semibold text-white">mundo emocional</span>, necesidades afectivas y reacciones instintivas. Es tu yo más íntimo y vulnerable.
                    <br><br>
                    <span class="block bg-[#3b82f6]/30 p-3 rounded-lg mt-4 border-l-4 border-[#A7B3EB]">
                        <span class="font-semibold text-[#ffffff]">Datos necesarios:</span> Fecha, hora y lugar de nacimiento
                    </span>
                </p>
            </div>

            <!-- Ascendente -->
            <div class="group bg-[#0A0E2A]/50 p-6 rounded-2xl shadow-xl backdrop-blur-sm hover:scale-[1.02] transition-all duration-300 border border-[#4A0E7B] border-opacity-40 hover:border-[#8A2BE2]/30">
                <div class="flex flex-col items-center mb-6">
                    <div class="w-20 h-20 bg-[#8A2BE2]/10 rounded-full flex items-center justify-center mb-4 border border-[#8A2BE2]/30 group-hover:bg-[#8A2BE2]/50 transition-colors">
                        <i class="fas fa-arrow-up text-3xl text-[#8A2BE2]"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white text-center">Ascendente</h3>
                    <div class="w-16 h-1 bg-[#8A2BE2] mt-2 rounded-full"></div>
                </div>
                <p class="text-[#E0E7FF] leading-relaxed">
                    Muestra cómo te <span class="font-semibold text-white">perciben los demás</span>, representa tu máscara social y tu estilo de interactuar con el mundo.
                    <br><br>
                    <span class="block bg-[#9333ea]/30 p-3 rounded-lg mt-4 border-l-4 border-[#8A2BE2]">
                        <span class="font-semibold text-[#b37fe4]">Datos necesarios:</span> Hora exacta y lugar de nacimiento
                    </span>
                </p>
            </div>
        </div>

        <!-- Sección de cálculo -->
        <div class="flex justify-center mb-16 animate-fade-in-up">
            <div class="bg-gradient-to-r from-[#1e3a8a]/40 to-[#9333ea]/40 rounded-2xl p-8 backdrop-blur-sm shadow-2xl max-w-4xl w-full border border-[#4A0E7B] border-opacity-40">
                <h2 class="text-2xl md:text-3xl font-bold mb-6 text-[#FFD700] text-center">
                    <span class="inline-flex items-center">
                        <i class="fas fa-calculator text-[#FFD700] mr-3"></i>
                        ¿Cómo calculamos tu carta astral?
                    </span>
                </h2>
                
                <div class="grid md:grid-cols-3 gap-6">
                    <div class="bg-[#0A0E2A]/50 p-5 rounded-xl border border-[#4A0E7B]/50">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-[#FFD700]/10 rounded-full flex items-center justify-center mr-3 border border-[#FFD700]/30">
                                <i class="fas fa-calendar-day text-[#FFD700]"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-white">Fecha exacta</h3>
                        </div>
                        <p class="text-[#E0E7FF] text-sm">Día, mes y año de tu nacimiento para determinar la posición del Sol y los planetas.</p>
                    </div>
                    
                    <div class="bg-[#0A0E2A]/50 p-5 rounded-xl border border-[#4A0E7B]/50">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-[#A7B3EB]/10 rounded-full flex items-center justify-center mr-3 border border-[#A7B3EB]/30">
                                <i class="fas fa-clock text-[#A7B3EB]"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-white">Hora precisa</h3>
                        </div>
                        <p class="text-[#E0E7FF] text-sm">La hora exacta (idealmente con minutos) para calcular tu Ascendente y Luna.</p>
                    </div>
                    
                    <div class="bg-[#0A0E2A]/50 p-5 rounded-xl border border-[#4A0E7B]/50">
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-[#8A2BE2]/10 rounded-full flex items-center justify-center mr-3 border border-[#8A2BE2]/30">
                                <i class="fas fa-map-marker-alt text-[#8A2BE2]"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-white">Lugar de nacimiento</h3>
                        </div>
                        <p class="text-[#E0E7FF] text-sm">Ciudad y país para ajustar las coordenadas celestes a tu ubicación geográfica.</p>
                    </div>
                </div>
                
                <div class="mt-8 bg-[#0A0E2A]/50 p-5 rounded-xl border border-[#4A0E7B]/50">
                    <p class="text-[#E0E7FF] text-center">
                        <i class="fas fa-info-circle text-[#FFD700] mr-2"></i>
                        <span class="font-medium">Mientras más precisos sean tus datos, más exacta será tu carta astral.</span> Usamos algoritmos astronómicos profesionales para calcular las posiciones planetarias.
                    </p>
                </div>
            </div>
        </div>

        <!-- Importancia en AstroMatch -->
        <div class="flex justify-center mb-16 animate-fade-in-up">
            <div class="bg-gradient-to-br from-[#FFD700]/10 to-[#8A2BE2]/10 rounded-2xl p-8 backdrop-blur-sm shadow-2xl max-w-4xl w-full border border-[#4A0E7B] border-opacity-40">
                <h2 class="text-2xl md:text-3xl font-bold mb-8 text-[#FFD700] text-center">
                    <span class="inline-flex items-center">
                        <i class="fas fa-heart mr-3"></i>
                        ¿Por qué es importante en AstroMatch?
                    </span>
                </h2>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="bg-[#0A0E2A]/50 p-5 rounded-xl border border-[#4A0E7B]/50 hover:border-[#FFD700]/30 transition-colors">
                        <div class="flex items-start mb-3">
                            <div class="flex-shrink-0 mt-1">
                                <i class="fas fa-users text-[#FFD700] text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-semibold text-white">Conexiones más profundas</h3>
                                <p class="text-[#E0E7FF] text-sm mt-1">Encuentra personas que realmente comprendan tu forma de ser y sentir.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-[#0A0E2A]/50 p-5 rounded-xl border border-[#4A0E7B]/50 hover:border-[#A7B3EB]/30 transition-colors">
                        <div class="flex items-start mb-3">
                            <div class="flex-shrink-0 mt-1">
                                <i class="fas fa-shield-alt text-[#A7B3EB] text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-semibold text-white">Evita conflictos</h3>
                                <p class="text-[#E0E7FF] text-sm mt-1">Identifica potenciales choques energéticos antes de que ocurran.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-[#0A0E2A]/50 p-5 rounded-xl border border-[#4A0E7B]/50 hover:border-[#8A2BE2]/30 transition-colors">
                        <div class="flex items-start mb-3">
                            <div class="flex-shrink-0 mt-1">
                                <i class="fas fa-magic text-[#8A2BE2] text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-semibold text-white">Recomendaciones precisas</h3>
                                <p class="text-[#E0E7FF] text-sm mt-1">Recibe sugerencias basadas en compatibilidad astrológica real.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-[#0A0E2A]/50 p-5 rounded-xl border border-[#4A0E7B]/50 hover:border-[#3b82f6]/30 transition-colors">
                        <div class="flex items-start mb-3">
                            <div class="flex-shrink-0 mt-1">
                                <i class="fas fa-chart-line text-[#3b82f6] text-lg"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-semibold text-white">Autoconocimiento</h3>
                                <p class="text-[#E0E7FF] text-sm mt-1">Descubre patrones en tus relaciones y cómo mejorarlas.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8 text-center">
                    <p class="text-[#E0E7FF] italic">
                        "La astrología es un lenguaje simbólico que nos ayuda a entender nuestros patrones y potenciales. No determina tu destino, pero puede iluminar tu camino."
                    </p>
                </div>
            </div>
        </div>

        <!-- CTA Final -->
        <div class="animate-fade-in">
            <h3 class="text-xl md:text-2xl font-bold mb-6 text-white text-center">
                ¿Listo para descubrir los secretos de tu carta astral?
            </h3>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-[#FFD700] to-[#F8C800] text-[#0A0E2A] font-bold rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl hover:shadow-[#FFD700]/30">
                    <i class="fas fa-rocket mr-3"></i> Calcula tu carta astral gratis
                </a>
                <a href="#" class="inline-flex items-center justify-center px-8 py-4 bg-transparent text-white font-bold rounded-full transition-all duration-300 border-2 border-[#A7B3EB] hover:bg-[#A7B3EB]/10 hover:border-[#A7B3EB]/80 hover:scale-105">
                    <i class="fas fa-book-open mr-3"></i> Aprende más
                </a>
            </div>
            <p class="text-[#A7B3EB] text-sm mt-4 text-center">
                <i class="fas fa-lock mr-1"></i> Tus datos están seguros y solo se usan para cálculos astrológicos.
            </p>
        </div>
    </div>
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
        animation: fadeIn 1s ease-out forwards;
    }
    
    .animate-fade-in-up {
        animation: fadeIn 0.8s ease-out 0.2s forwards;
        opacity: 0;
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