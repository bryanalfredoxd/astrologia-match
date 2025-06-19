<!-- Sección del Signo Lunar -->
<div class="bg-gradient-to-r from-[#4A0E7B] to-[#1A1F4D] backdrop-blur-sm rounded-2xl p-6 mb-6 shadow-lg">
    {{-- Título Centrado --}}
    <div class="flex items-center justify-center mb-4">
        <h2 class="text-xl sm:text-2xl font-bold flex items-center text-center">
            <i class="fas fa-moon text-[#FFD700] mr-3"></i>
            Mi Signo Lunar
        </h2>
    </div>

    @if(isset($lunarSign) && $lunarSign->nombre_signo !== 'Nada')
        {{-- Contenedor principal de los tres elementos (Signo, Elemento, Modalidad) --}}
        <div class="grid grid-cols-3 gap-x-4 sm:gap-x-6 md:gap-x-16 justify-items-center mt-6 md:mt-8">
            {{-- Columna 1: Signo Lunar (Imagen y Nombre) --}}
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-[#0A0E2A] border-2 border-[#FFD700] flex items-center justify-center mb-2">
                    <?php
                        $signoSlug = isset($lunarSign->nombre_signo) ? strtolower($lunarSign->nombre_signo) : '';
                    ?>
                    <img src="{{ asset('images/zodiaco/' . $signoSlug . '.png') }}" alt="{{ $lunarSign->nombre_signo ?? 'Signo Lunar' }}" class="w-full h-full object-contain p-1">
                </div>
                <h4 class="text-base sm:text-lg font-bold text-[#FFD700]">
                    {{ $lunarSign->nombre_signo ?? 'N/A' }}
                </h4>
            </div>

            {{-- Columna 2: Elemento (Icono y Nombre del Elemento) --}}
            @php
                $elemento = $lunarSign->elemento ?? '';
                $iconoElemento = '';
                $colorElemento = 'text-white';

                switch ($elemento) {
                    case 'Fuego':
                        $iconoElemento = 'fa-fire';
                        $colorElemento = 'text-red-500';
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
                    default:
                        $iconoElemento = 'fa-question';
                        $colorElemento = 'text-white';
                        break;
                }
            @endphp
            <div class="flex flex-col items-center text-center">
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-[#0A0E2A] border-2 border-[#FFD700] flex items-center justify-center mb-2">
                    <i class="fas {{ $iconoElemento }} {{ $colorElemento }} text-3xl sm:text-4xl"></i>
                </div>
                <p class="text-base sm:text-lg font-bold text-[#FFD700]">{{ $elemento }}</p>
            </div>

            {{-- Columna 3: Modalidad (Icono y Nombre de la Modalidad) --}}
            @php
                $modalidad = $lunarSign->modalidad ?? '';
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
                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-[#0A0E2A] border-2 border-[#FFD700] flex items-center justify-center mb-2">
                    <i class="fas {{ $iconoModalidad }} {{ $colorModalidad }} text-3xl sm:text-4xl"></i>
                </div>
                <p class="text-base sm:text-lg font-bold text-[#FFD700]">{{ $modalidad }}</p>
            </div>
        </div>

        <div class="mt-8 pt-4 border-t border-[#4A0E7B] text-center">
            <h3 class="text-lg font-bold text-[#FFD700] mb-3">Análisis de tu Signo Lunar</h3>
            <div id="lunar-analysis-text" class="text-[#A7B3EB] text-sm leading-relaxed">
                <i class="fas fa-spinner fa-spin text-xl text-[#FFD700]"></i> Cargando análisis...
            </div>
        </div>
    @else
        <p class="text-[#A7B3EB] text-center mt-6">
            Tu Signo Lunar aún no ha sido calculado. Completa tu perfil y usa la función de IA para obtenerlo.
        </p>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', async function() {
        const lunarSignData = {
            nombre_signo: "{{ $lunarSign->nombre_signo ?? 'Nada' }}",
            elemento: "{{ $lunarSign->elemento ?? '' }}",
            modalidad: "{{ $lunarSign->modalidad ?? '' }}"
        };
        const analysisDiv = document.getElementById('lunar-analysis-text');

        if (lunarSignData.nombre_signo && lunarSignData.nombre_signo !== 'Nada') {
            try {
                const prompt = `Genera un análisis astrológico conciso y motivador (máximo 150 palabras) para una persona con el Signo Lunar ${lunarSignData.nombre_signo}, Elemento ${lunarSignData.elemento}, y Modalidad ${lunarSignData.modalidad}. Enfócate en cómo estas características influyen en sus emociones, intuición, reacciones subconscientes y su mundo interior. Menciona cómo puede aprovechar estas energías en sus relaciones y crecimiento personal. Usa un tono positivo y alentador.`;

                let chatHistory = [];
                chatHistory.push({ role: "user", parts: [{ text: prompt }] });
                const payload = { contents: chatHistory };
                const apiKey = ""; // La API key será provista en runtime por Canvas

                const apiUrl = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${apiKey}`;
                const response = await fetch(apiUrl, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();
                if (result.candidates && result.candidates.length > 0 &&
                    result.candidates[0].content && result.candidates[0].content.parts &&
                    result.candidates[0].content.parts.length > 0) {
                    const text = result.candidates[0].content.parts[0].text;
                    analysisDiv.innerHTML = text; // Mostrar el texto generado
                } else {
                    analysisDiv.innerHTML = '<span class="text-red-400">Error: No se pudo generar el análisis (respuesta inesperada).</span>';
                    console.error('Error al generar análisis lunar: Respuesta inesperada de la API', result);
                }
            } catch (error) {
                analysisDiv.innerHTML = '<span class="text-red-400">Error al cargar el análisis. Inténtalo de nuevo más tarde.</span>';
                console.error('Error al llamar a la API de Gemini para análisis lunar:', error);
            }
        } else {
            analysisDiv.innerHTML = 'Análisis disponible una vez que se calcule tu Signo Lunar.';
            analysisDiv.classList.add('italic', 'text-gray-400');
        }
    });
</script>
