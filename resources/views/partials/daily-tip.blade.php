<!-- Consejo del Día -->
<div class="bg-gradient-to-r from-[#4A0E7B] to-[#1A1F4D] backdrop-blur-sm rounded-2xl p-6 shadow-lg mb-20 sm:mb-20">
    <div class="flex items-center justify-center mb-4"> {{-- justify-center para centrar el título --}}
        <i class="fas fa-calendar-days text-2xl text-[#FFD700] mr-3"></i>
        <h2 class="text-lg font-bold">Consejo Astral del Día</h2>
    </div>

    <div id="daily-tip-content" class="text-[#c0cbff] text-sm leading-relaxed text-center mb-4">
        <i class="fas fa-spinner fa-spin text-xl text-[#FFD700]"></i> Cargando consejo astral...
    </div>

    {{-- El botón "Ver análisis completo" se elimina ya que el contenido principal es el análisis --}}
</div>

<script>
    document.addEventListener('DOMContentLoaded', async function() {
        const dailyTipContentDiv = document.getElementById('daily-tip-content');
        const today = new Date().toDateString(); // Formato de fecha para el cache diario

        // Recuperar el consejo y la fecha del almacenamiento local
        let storedTip = localStorage.getItem('dailyAstroTipContent');
        const storedDate = localStorage.getItem('dailyAstroTipDate');

        // Función para formatear el texto del consejo
        function formatDailyTip(text) {
            let formattedHtml = '';
            // Dividir el texto por las secciones principales
            const sections = text.split(/\*\*(Crecimiento personal|Relaciones|Oportunidades):\*\*/);

            // La primera parte es la introducción
            if (sections[0].trim().length > 0) {
                formattedHtml += `<p class="mb-4">${sections[0].trim()}</p>`;
            }

            // Iterar sobre las secciones restantes (pares de título y contenido)
            for (let i = 1; i < sections.length; i += 2) {
                const title = sections[i].trim();
                const content = sections[i + 1].trim();
                if (title && content) {
                    formattedHtml += `
                        <div class="mb-4 p-3 bg-[#4A0E7B] bg-opacity-20 rounded-lg">
                            <h4 class="text-[#FFD700] font-semibold text-base mb-2">${title}:</h4>
                            <p>${content}</p>
                        </div>
                    `;
                }
            }
            return formattedHtml;
        }

        // Comprobar si ya tenemos un consejo para hoy y está bien formateado
        if (storedTip && storedDate === today) {
            // Se asume que el storedTip ya podría estar formateado con el HTML
            dailyTipContentDiv.innerHTML = storedTip;
            return; // Salir de la función, no es necesario generar un nuevo consejo
        }

        // Si no hay consejo para hoy o no está en el formato esperado, intentar generarlo
        try {
            // Asegúrate de que las variables de Blade estén definidas antes de usarlas
            const solarSignName = "{{ $user->datosAstralesBasicos->signoSolar->nombre_signo ?? 'No Definido' }}";
            const solarElement = "{{ $user->datosAstralesBasicos->signoSolar->elemento ?? 'No Definido' }}";
            const solarModality = "{{ $user->datosAstralesBasicos->signoSolar->modalidad ?? 'No Definido' }}";

            const lunarSignName = "{{ $lunarSign->nombre_signo ?? 'No Definido' }}";
            const lunarElement = "{{ $lunarSign->elemento ?? 'No Definido' }}";
            const lunarModality = "{{ $lunarSign->modalidad ?? 'No Definido' }}";

            const ascendantSignName = "{{ $ascendantSign->nombre_signo ?? 'No Definido' }}";
            const ascendantElement = "{{ $ascendantSign->elemento ?? 'No Definido' }}";
            const ascendantModality = "{{ $ascendantSign->modalidad ?? 'No Definido' }}";

            // Solo generar el consejo si los signos principales están definidos y no son "Nada"
            if (solarSignName === 'No Definido' || lunarSignName === 'No Definido' || ascendantSignName === 'No Definido' ||
                solarSignName === 'Nada' || lunarSignName === 'Nada' || ascendantSignName === 'Nada') {
                dailyTipContentDiv.innerHTML = 'Completa tu perfil y tus datos astrales para recibir tu consejo diario personalizado.';
                dailyTipContentDiv.classList.add('italic', 'text-gray-400');
                return;
            }

            const prompt = `Genera un consejo astral diario detallado y personalizado (máximo 200 palabras) para un usuario con:
            - Signo Solar: ${solarSignName}, Elemento: ${solarElement}, Modalidad: ${solarModality}
            - Signo Lunar: ${lunarSignName}, Elemento: ${lunarElement}, Modalidad: ${lunarModality}
            - Ascendente: ${ascendantSignName}, Elemento: ${ascendantElement}, Modalidad: ${ascendantModality}

            El consejo debe ser inspirador, práctico y enfocarse en las energías del día para el crecimiento personal, las relaciones y oportunidades. Considera la interacción entre estos tres pilares astrológicos. Usa un tono positivo y alentador. Formatea las secciones "Crecimiento personal", "Relaciones" y "Oportunidades" con doble asterisco al inicio y al final del título (ej. **Crecimiento personal:**).`
            ;
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
                const rawText = result.candidates[0].content.parts[0].text;
                const formattedText = formatDailyTip(rawText); // Formatear el texto
                dailyTipContentDiv.innerHTML = formattedText;

                // Guardar el CONSEJO YA FORMATEADO y la fecha en el almacenamiento local
                localStorage.setItem('dailyAstroTipContent', formattedText);
                localStorage.setItem('dailyAstroTipDate', today);
            } else {
                dailyTipContentDiv.innerHTML = '<span class="text-red-400">Error: No se pudo generar el consejo (respuesta inesperada).</span>';
                console.error('Error al generar consejo diario: Respuesta inesperada de la API', result);
            }
        } catch (error) {
            dailyTipContentDiv.innerHTML = '<span class="text-red-400">Error al cargar el consejo. Inténtalo de nuevo más tarde.</span>';
            console.error('Error al llamar a la API de Gemini para consejo diario:', error);
        }
    });
</script>
