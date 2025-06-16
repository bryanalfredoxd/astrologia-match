@extends('layouts.app_sesion')

@section('content')
<section class="bg-[#0A0E2A] text-white min-h-screen py-10 px-4 sm:px-6 relative overflow-hidden flex items-center justify-center">

    <div class="max-w-7xl mx-auto text-center relative z-10 w-full">
        <h1 class="text-3xl md:text-5xl font-bold mb-8 text-[#FFD700]">Tus Matches Potenciales</h1>

        <div id="matchCardContainer" class="relative w-full max-w-md mx-auto h-[480px] sm:h-[550px] md:h-[600px] flex items-center justify-center">
            {{-- La tarjeta de match se inyectará aquí via JavaScript --}}
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

    <!-- Script de lógica de matches -->
    <script>
        // Datos de ejemplo para los matches
        const matchesData = [
            { id: 1, name: 'Sofia', age: 24, sign: 'Géminis', bio: 'Amo la astrología y las conversaciones profundas. Busco una conexión auténtica.', avatar: 'https://i.pravatar.cc/150?img=1' },
            { id: 2, name: 'Carlos', age: 28, sign: 'Leo', bio: 'Me encanta la aventura y el aire libre. Un buen café y una mejor compañía.', avatar: 'https://i.pravatar.cc/150?img=2' },
            { id: 3, name: 'Elena', age: 22, sign: 'Libra', bio: 'Creativa y soñadora, apasionada por el arte y la música. ¿Hablamos de nuestras cartas?', avatar: 'https://i.pravatar.cc/150?img=3' },
            { id: 4, name: 'Miguel', age: 30, sign: 'Capricornio', bio: 'Trabajador y ambicioso, pero siempre con tiempo para una buena conversación y reír.', avatar: 'https://i.pravatar.cc/150?img=4' },
            { id: 5, name: 'Laura', age: 26, sign: 'Acuario', bio: 'De mente abierta y curiosa. Fanática de las nuevas experiencias y la tecnología.', avatar: 'https://i.pravatar.cc/150?img=5' },
            { id: 6, name: 'David', age: 29, sign: 'Tauro', bio: 'Disfruto de la tranquilidad, la buena comida y los planes relajados. Busco estabilidad.', avatar: 'https://i.pravatar.cc/150?img=6' },
        ];

        let currentMatchIndex = 0;
        const matchCardContainer = document.getElementById('matchCardContainer');
        const dislikeBtn = document.getElementById('dislikeBtn');
        const likeBtn = document.getElementById('likeBtn');
        const noMatchesMessage = document.getElementById('noMatchesMessage');

        /**
         * Renderiza la tarjeta del match actual.
         * @param {Object} match - Objeto con los datos del match.
         */
        function renderMatchCard(match) {
            matchCardContainer.innerHTML = `
                <div id="currentMatchCard" class="bg-white bg-opacity-10 p-6 rounded-2xl shadow-lg backdrop-blur-sm
                                                w-full max-w-md mx-auto
                                                border border-[#4A0E7B] border-opacity-40
                                                flex flex-col items-center justify-center transition-all duration-300 ease-out
                                                absolute top-0 left-0 h-full">
                    <img src="${match.avatar}" alt="Foto de ${match.name}"
                         class="w-32 h-32 rounded-full border-4 border-yellow-300 object-cover mb-4 shadow-md">
                    <h2 class="text-3xl font-bold text-white mb-2">${match.name}, ${match.age}</h2>
                    <p class="text-xl text-[#FFD700] mb-4">Signo: ${match.sign}</p>
                    <p class="text-[#A7B3EB] text-center px-4 leading-relaxed flex-grow">${match.bio}</p>
                </div>
            `;
            // Forzar reflow para que la animación funcione al reaparecer el elemento
            void matchCardContainer.offsetWidth;
            const currentCard = document.getElementById('currentMatchCard');
            currentCard.classList.remove('opacity-0', 'scale-95'); // Eliminar clases de "salida" si existen
        }

        /**
         * Maneja el "dislike" o "like" moviendo la tarjeta y mostrando la siguiente.
         * @param {string} type - Tipo de acción ('like' o 'dislike').
         */
        function handleSwipe(type) {
            const currentCard = document.getElementById('currentMatchCard');
            if (!currentCard) return;

            // Animación de salida
            currentCard.classList.add(type === 'like' ? 'animate-swipe-right' : 'animate-swipe-left');

            setTimeout(() => {
                currentCard.remove(); // Eliminar la tarjeta después de la animación

                currentMatchIndex++;
                if (currentMatchIndex < matchesData.length) {
                    renderMatchCard(matchesData[currentMatchIndex]);
                } else {
                    // No hay más matches
                    matchCardContainer.innerHTML = '';
                    noMatchesMessage.classList.remove('hidden');
                    dislikeBtn.disabled = true;
                    likeBtn.disabled = true;
                    dislikeBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    likeBtn.classList.add('opacity-50', 'cursor-not-allowed');
                }
            }, 300); // Duración de la animación
        }

        // Event Listeners para los botones
        dislikeBtn.addEventListener('click', () => handleSwipe('dislike'));
        likeBtn.addEventListener('click', () => handleSwipe('like'));

        // Cargar el primer match al cargar la página
        document.addEventListener('DOMContentLoaded', () => {
            if (matchesData.length > 0) {
                renderMatchCard(matchesData[currentMatchIndex]);
            } else {
                noMatchesMessage.classList.remove('hidden');
                dislikeBtn.disabled = true;
                likeBtn.disabled = true;
                dislikeBtn.classList.add('opacity-50', 'cursor-not-allowed');
                likeBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        });
    </script>

    <!-- Estilos de animación personalizados para las tarjetas -->
    <style>
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
    </style>

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
</style>
@endsection