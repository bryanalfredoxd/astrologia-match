@extends('layouts.app_sesion')

@section('content')
<section class="bg-[#0A0E2A] text-white min-h-screen py-10 px-4 sm:px-6 relative overflow-hidden flex items-center justify-center">

    <div class="max-w-7xl mx-auto text-center relative z-10 w-full">
        <h1 class="text-3xl md:text-5xl font-bold mb-8 text-[#FFD700]">Tus Matches Potenciales</h1>

        <div id="matchCardContainer" class="relative w-full max-w-md mx-auto h-[480px] sm:h-[550px] md:h-[600px] flex items-center justify-center">
            {{-- La tarjeta de match se inyectará aquí via JavaScript --}}
            <p id="loadingMessage" class="text-[#A7B3EB] text-lg">Cargando matches...</p>
            <p id="noMatchesMessage" class="text-[#A7B3EB] text-lg hidden">¡Has visto todos los matches por ahora! Vuelve más tarde.</p>
        </div>

        <div class="flex justify-center space-x-6 mt-8">
            <button id="dislikeBtn" class="bg-red-600 text-white p-4 rounded-full shadow-lg hover:bg-red-700 transition-all transform hover:scale-110 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75">
                <i class="fas fa-times text-2xl"></i>
            </button>
            <button id="likeBtn" class="bg-green-600 text-white p-4 rounded-full shadow-lg hover:bg-green-700 transition-all transform hover:scale-110 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-75">
                <i class="fas fa-heart text-2xl"></i>
            </button>
        </div>
    </div>

    {{-- Modal de Match --}}
    <div id="matchModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden p-4">
        <div class="bg-gradient-to-r from-[#4A0E7B] to-[#1A1F4D] p-8 rounded-2xl shadow-xl border border-[#FFD700]/30 text-center relative max-w-sm mx-auto">
            <h2 class="text-3xl font-bold text-[#FFD700] mb-4">¡Es un Match!</h2>
            <p class="text-lg text-white mb-6">Tú y <span id="matchUserName" class="font-semibold"></span> se han gustado mutuamente.</p>
            <img id="matchUserAvatar" src="" alt="Match Avatar" class="w-32 h-32 rounded-full mx-auto mb-6 border-4 border-[#FFD700] shadow-md object-cover">
            <button id="closeMatchModal" class="bg-[#FFD700] hover:bg-[#F8C800] text-[#0A0E2A] font-bold py-3 px-6 rounded-full transition duration-300">
                Ver Perfil
            </button>
        </div>
    </div>

    <!-- Elementos decorativos de fondo (copia de carta_astral.blade.php para consistencia) -->
    <div class="absolute top-0 left-0 w-48 h-48 bg-[#4A0E7B] rounded-full mix-blend-screen opacity-10 blur-3xl animate-blob -z-10"></div>
    <div class="absolute bottom-0 right-0 w-48 h-48 bg-[#8A2BE2] rounded-full mix-blend-screen opacity-10 blur-3xl animate-blob animation-delay-2000 -z-10"></div>
    <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-[#FFD700] rounded-full mix-blend-screen opacity-5 blur-3xl animate-blob animation-delay-4000 -z-10"></div>
</section>

@include('partials.desktop-nav')
@include('partials.mobile-nav')

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

    /* Animaciones de tarjeta */
    @keyframes swipe-left {
        from { transform: translateX(0) rotate(0deg); opacity: 1; }
        to { transform: translateX(-150%) rotate(-30deg); opacity: 0; }
    }

    @keyframes swipe-right {
        from { transform: translateX(0) rotate(0deg); opacity: 1; }
        to { transform: translateX(150%) rotate(30deg); opacity: 0; }
    }

    .animate-swipe-left {
        animation: swipe-left 0.3s ease-out forwards;
    }

    .animate-swipe-right {
        animation: swipe-right 0.3s ease-out forwards;
    }

    .match-card {
        transition: transform 0.3s ease-out, opacity 0.3s ease-out;
    }

    /* Estilos para el desplegable del análisis detallado */
    .collapse-content {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease-out;
    }

    .collapse-content.expanded {
        max-height: 300px; /* Ajusta esto según el contenido máximo esperado */
    }

    .rotate-icon {
        transition: transform 0.3s ease-out;
    }

    .rotate-icon.rotated {
        transform: rotate(180deg);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const matchCardContainer = document.getElementById('matchCardContainer');
        const loadingMessage = document.getElementById('loadingMessage');
        const noMatchesMessage = document.getElementById('noMatchesMessage');
        const likeBtn = document.getElementById('likeBtn');
        const dislikeBtn = document.getElementById('dislikeBtn');
        const matchModal = document.getElementById('matchModal');
        const matchUserName = document.getElementById('matchUserName');
        const matchUserAvatar = document.getElementById('matchUserAvatar');
        const closeMatchModalBtn = document.getElementById('closeMatchModal');

        let matches = [];
        let currentMatchIndex = 0;
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        /**
         * Carga los matches potenciales desde la API.
         */
        async function fetchMatches() {
            loadingMessage.classList.remove('hidden');
            noMatchesMessage.classList.add('hidden');
            matchCardContainer.innerHTML = ''; // Limpiar contenedor de tarjetas

            try {
                const response = await fetch('{{ route('matches.get') }}');
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                matches = data.matches;
                currentMatchIndex = 0; // Resetear índice al cargar nuevos matches
                displayCurrentMatch();
            } catch (error) {
                console.error('Error al cargar matches:', error);
                loadingMessage.textContent = 'Error al cargar matches. Por favor, intenta de nuevo más tarde.';
                loadingMessage.classList.remove('hidden');
                matchCardContainer.innerHTML = '';
                likeBtn.disabled = true;
                dislikeBtn.disabled = true;
            } finally {
                loadingMessage.classList.add('hidden');
            }
        }

        /**
         * Muestra la tarjeta del match actual o el mensaje de "no hay matches".
         */
        function displayCurrentMatch() {
            if (matches.length > 0 && currentMatchIndex < matches.length) {
                const match = matches[currentMatchIndex];
                matchCardContainer.innerHTML = createMatchCardHtml(match);
                noMatchesMessage.classList.add('hidden');
                likeBtn.disabled = false;
                dislikeBtn.disabled = false;

                // Añadir evento al botón de "Ver Análisis Detallado"
                const toggleAnalysisBtn = document.getElementById('toggleAnalysisBtn');
                if (toggleAnalysisBtn) {
                    toggleAnalysisBtn.addEventListener('click', function() {
                        const detailedAnalysisContent = document.getElementById('detailedAnalysisContent');
                        const icon = this.querySelector('i');
                        detailedAnalysisContent.classList.toggle('expanded');
                        icon.classList.toggle('rotated');
                        if (detailedAnalysisContent.classList.contains('expanded')) {
                            this.textContent = 'Ocultar Análisis Detallado ';
                            this.appendChild(icon);
                        } else {
                            this.textContent = 'Ver Análisis Detallado ';
                            this.appendChild(icon);
                        }
                    });
                }

            } else {
                matchCardContainer.innerHTML = '';
                noMatchesMessage.classList.remove('hidden');
                likeBtn.disabled = true;
                dislikeBtn.disabled = true;
            }
        }

        /**
         * Crea el HTML para una tarjeta de match.
         * @param {Object} match - Los datos del match.
         * @returns {string} HTML de la tarjeta.
         */
        function createMatchCardHtml(match) {
            // Placeholder para foto de perfil si no existe
            const photoUrl = match.foto_perfil_url
                ? `{{ asset('') }}${match.foto_perfil_url}`
                : `https://placehold.co/150x150/4A0E7B/FFFFFF?text=${match.nombre_completo.charAt(0).toUpperCase()}`;

            // Determinar color de puntuación
            let scoreColorClass = 'text-gray-400'; // Default
            if (match.puntuacion_general >= 85) {
                scoreColorClass = 'text-green-400';
            } else if (match.puntuacion_general >= 70) {
                scoreColorClass = 'text-lime-400';
            } else if (match.puntuacion_general >= 50) {
                scoreColorClass = 'text-yellow-400';
            } else if (match.puntuacion_general >= 30) {
                scoreColorClass = 'text-orange-400';
            } else {
                scoreColorClass = 'text-red-400';
            }


            return `
                <div id="matchCard-${match.id}" data-match-id="${match.id}" class="match-card bg-gradient-to-r from-[#4A0E7B] to-[#1A1F4D] rounded-2xl shadow-xl border border-[#FFD700]/30 p-6 sm:p-8 w-full h-full flex flex-col items-center justify-center text-white relative">
                    <img src="${photoUrl}" alt="${match.nombre_completo}" class="w-32 h-32 sm:w-40 sm:h-40 rounded-full object-cover mb-4 border-4 border-[#FFD700] shadow-md">
                    <h2 class="text-2xl sm:text-3xl font-bold mb-2 text-[#FFD700]">${match.nombre_completo}, ${match.edad}</h2>
                    <p class="text-sm sm:text-base text-[#A7B3EB] mb-1">
                        <i class="fas fa-map-marker-alt mr-1"></i> ${match.lugar_nacimiento}
                        ${match.distancia_km !== null ? `(${match.distancia_km} km)` : ''}
                    </p>
                    <p class="text-sm sm:text-base text-[#A7B3EB] mb-4">${match.genero} - ${match.orientacion_sexual}</p>

                    <div class="text-center mb-4">
                        <p class="font-semibold text-lg text-white mb-1">
                            Compatibilidad Astrológica: <span class="font-bold ${scoreColorClass}">${match.puntuacion_general}%</span>
                        </p>
                        <p class="text-sm text-[#A7B3EB]">${match.descripcion_breve}</p>
                    </div>

                    {{-- Sección de Análisis Detallado Desplegable --}}
                    <div class="w-full flex justify-center mb-4">
                        <button id="toggleAnalysisBtn" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-sm px-4 py-2 rounded-full transition duration-300 flex items-center">
                            Ver Análisis Detallado <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
                        </button>
                    </div>
                    <div id="detailedAnalysisContent" class="collapse-content text-sm text-[#E0E7FF] text-left w-full p-3 rounded-lg border border-white/10 bg-black bg-opacity-20 leading-relaxed custom-scrollbar">
                        <p class="font-semibold text-[#FFD700] mb-2">Análisis Detallado:</p>
                        <p>${match.analisis_detallado}</p>
                    </div>
                </div>
            `;
        }

        /**
         * Maneja la interacción del usuario (like/dislike).
         * @param {string} type - 'like' o 'dislike'.
         */
        async function handleInteraction(type) {
            const currentCard = matchCardContainer.querySelector('.match-card');
            if (!currentCard) return;

            const targetUserId = currentCard.dataset.matchId;
            const targetUserName = matches[currentMatchIndex].nombre_completo; // Obtener el nombre para el modal
            const targetUserAvatar = matches[currentMatchIndex].foto_perfil_url; // Obtener la URL del avatar para el modal


            // Añadir clase de animación
            if (type === 'dislike') {
                currentCard.classList.add('animate-swipe-left');
            } else {
                currentCard.classList.add('animate-swipe-right');
            }

            // Deshabilitar botones para evitar múltiples clics
            likeBtn.disabled = true;
            dislikeBtn.disabled = true;

            // Esperar a que la animación termine antes de procesar la interacción
            currentCard.addEventListener('animationend', async () => {
                try {
                    const response = await fetch(`{{ url('/api/matches') }}/${targetUserId}/interact/${type}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({}) // No se necesita cuerpo si solo se envía el tipo
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();
                    console.log(data.message);

                    if (data.is_match) {
                        showMatchModal(targetUserName, targetUserAvatar, targetUserId); // Pasar el ID del usuario al modal
                    } else {
                        // Si no hay match, simplemente pasar al siguiente
                        currentMatchIndex++;
                        displayCurrentMatch();
                    }

                } catch (error) {
                    console.error('Error al procesar interacción:', error);
                    // Re-habilitar botones si falla la interacción
                    likeBtn.disabled = false;
                    dislikeBtn.disabled = false;
                    // Opcional: Mostrar un mensaje de error al usuario
                }
            }, { once: true }); // El evento se dispara solo una vez
        }

        // Event Listeners para los botones de interacción
        likeBtn.addEventListener('click', () => handleInteraction('like'));
        dislikeBtn.addEventListener('click', () => handleInteraction('dislike'));

        // Funcionalidad del Modal de Match
        function showMatchModal(userName, userAvatarUrl, userId) {
            matchUserName.textContent = userName;
            // Usar placeholder si no hay URL o si la URL es null/vacía
            matchUserAvatar.src = userAvatarUrl ? `{{ asset('') }}${userAvatarUrl}` : `https://placehold.co/150x150/4A0E7B/FFFFFF?text=Match`;
            matchModal.classList.remove('hidden');
            // Almacenar el userId en el botón "Ver Perfil" del modal
            closeMatchModalBtn.dataset.userId = userId;
        }

        closeMatchModalBtn.addEventListener('click', function() {
            const matchedUserId = this.dataset.userId;
            if (matchedUserId) {
                // Redirigir a la nueva pantalla de perfil
                window.location.href = `{{ url('/matched-profile') }}/${matchedUserId}`;
            }
        });

        // Cargar matches al iniciar la página
        fetchMatches();
    });
</script>
@endsection
