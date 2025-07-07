@extends('layouts.app_sesion')

@section('content')
<section class="bg-[#0A0E2A] text-white min-h-screen py-8 px-4 sm:px-6 relative overflow-hidden flex flex-col items-center justify-start pt-20">

    <div class="absolute top-0 left-0 w-48 h-48 bg-[#4A0E7B] rounded-full mix-blend-screen opacity-10 blur-3xl animate-blob -z-10"></div>
    <div class="absolute bottom-0 right-0 w-48 h-48 bg-[#8A2BE2] rounded-full mix-blend-screen opacity-10 blur-3xl animate-blob animation-delay-2000 -z-10"></div>
    <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-[#FFD700] rounded-full mix-blend-screen opacity-5 blur-3xl animate-blob animation-delay-4000 -z-10"></div>

    <div class="max-w-7xl mx-auto text-center relative z-10 w-full flex flex-col items-center justify-center">
        <h1 class="text-4xl md:text-6xl font-extrabold mb-8 text-[#FFD700] drop-shadow-lg">Encuentra tu Conexión Cósmica</h1>

        {{-- Removed fixed height from matchCardContainer here. The card will define its height. --}}
        <div id="matchCardContainer" class="relative w-full max-w-sm sm:max-w-md md:max-w-lg lg:max-w-xl xl:max-w-2xl mx-auto flex items-center justify-center p-4 min-h-[550px]">
            {{-- Match card will be injected here via JavaScript --}}
            <p id="loadingMessage" class="text-[#A7B3EB] text-xl font-semibold animate-pulse">Cargando posibles conexiones...</p>
            <p id="noMatchesMessage" class="text-[#A7B3EB] text-xl font-semibold hidden">
                ¡Parece que has visto a todos por ahora! Vuelve más tarde o ajusta tus preferencias.
            </p>
        </div>

        <div class="flex justify-center space-x-8 mt-8 w-full max-w-sm">
            <button id="dislikeBtn" aria-label="Dislike profile" class="flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-red-600 text-white rounded-full shadow-2xl hover:bg-red-700 transition-all duration-300 transform hover:scale-110 focus:outline-none focus:ring-4 focus:ring-red-500 focus:ring-opacity-75 relative overflow-hidden group">
                <i class="fas fa-times text-3xl group-hover:scale-125 transition-transform duration-300"></i>
                <span class="absolute inset-0 bg-red-500 opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
            </button>
            <button id="likeBtn" aria-label="Like profile" class="flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-green-600 text-white rounded-full shadow-2xl hover:bg-green-700 transition-all duration-300 transform hover:scale-110 focus:outline-none focus:ring-4 focus:ring-green-500 focus:ring-opacity-75 relative overflow-hidden group">
                <i class="fas fa-heart text-3xl group-hover:scale-125 transition-transform duration-300"></i>
                <span class="absolute inset-0 bg-green-500 opacity-0 group-hover:opacity-20 transition-opacity duration-300"></span>
            </button>
        </div>
    </div>

    {{-- Floating Filter Button --}}
    <button id="filterBtn" class="fixed top-4 right-4 z-40 bg-[#FFD700] text-[#0A0E2A] w-14 h-14 rounded-full shadow-xl flex items-center justify-center text-2xl hover:bg-[#F8C800] transition-all duration-300 transform hover:scale-110 focus:outline-none focus:ring-4 focus:ring-[#FFD700] focus:ring-opacity-75 animate-bounce-slow" aria-label="Abrir filtros de búsqueda">
        <i class="fas fa-filter"></i>
    </button>

    {{-- Filter Modal (Off-canvas) --}}
<div id="filterModal" class="fixed inset-0 bg-black bg-opacity-70 z-50 hidden flex justify-end overflow-y-auto" aria-hidden="true">
    <div class="bg-gradient-to-br from-[#1A1F4D] to-[#4A0E7B] w-full max-w-sm min-h-screen overflow-y-auto transform translate-x-full transition-transform duration-300 ease-in-out p-6 shadow-2xl relative" role="dialog" aria-labelledby="filterModalTitle">
        <button id="closeFilterModalBtn" class="absolute top-4 left-4 text-white hover:text-[#FFD700] text-3xl z-10" aria-label="Cerrar filtros">
            <i class="fas fa-times-circle"></i>
        </button>
        <h2 id="filterModalTitle" class="text-3xl font-extrabold text-[#FFD700] mb-8 text-center pt-4">Filtros de Búsqueda</h2>

        <form id="filterForm" class="space-y-6 pb-24"> <!-- Añadido pb-24 para espacio en móviles -->
            {{-- Edad --}}
            <div>
                <label for="age_min" class="block text-lg font-semibold text-white mb-2">Edad:</label>
                <div class="flex items-center space-x-4">
                    <input type="number" id="age_min" name="age_min" min="18" max="100" placeholder="Min" class="w-1/2 p-3 rounded-xl bg-gray-800 text-white border border-[#FFD700]/30 focus:border-[#FFD700] focus:ring focus:ring-[#FFD700]/50 outline-none">
                    <span class="text-white">-</span>
                    <input type="number" id="age_max" name="age_max" min="18" max="100" placeholder="Max" class="w-1/2 p-3 rounded-xl bg-gray-800 text-white border border-[#FFD700]/30 focus:border-[#FFD700] focus:ring focus:ring-[#FFD700]/50 outline-none">
                </div>
            </div>

            {{-- Género --}}
            <div>
                <label for="genero_filter" class="block text-lg font-semibold text-white mb-2">Género:</label>
                <select id="genero_filter" name="genero" class="w-full p-3 rounded-xl bg-gray-800 text-white border border-[#FFD700]/30 focus:border-[#FFD700] focus:ring focus:ring-[#FFD700]/50 outline-none">
                    <option value="">Todos</option>
                    {{-- Opciones cargadas dinámicamente --}}
                </select>
            </div>

            {{-- Orientación Sexual --}}
            <div>
                <label for="orientacion_sexual_filter" class="block text-lg font-semibold text-white mb-2">Orientación Sexual:</label>
                <select id="orientacion_sexual_filter" name="orientacion_sexual" class="w-full p-3 rounded-xl bg-gray-800 text-white border border-[#FFD700]/30 focus:border-[#FFD700] focus:ring focus:ring-[#FFD700]/50 outline-none">
                    <option value="">Todas</option>
                    {{-- Opciones cargadas dinámicamente --}}
                </select>
            </div>

            {{-- Botones de acción --}}
            <div class="flex justify-between mt-8 pt-4 border-t border-white/10">
                <button type="button" id="resetFiltersBtn" class="px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-bold rounded-full transition duration-300 transform hover:scale-105 shadow-lg">
                    Limpiar Filtros
                </button>
                <button type="submit" class="px-6 py-3 bg-[#FFD700] hover:bg-[#F8C800] text-[#0A0E2A] font-extrabold rounded-full transition duration-300 transform hover:scale-105 shadow-lg">
                    Aplicar Filtros
                </button>
            </div>
        </form>

        <!-- Espacio adicional solo para móviles -->
        <div class="block sm:hidden h-5"></div>
    </div>
</div>

    {{-- Match Modal --}}
    <div id="matchModal" class="fixed inset-0 bg-black bg-opacity-85 flex items-center justify-center z-50 p-4 hidden animate-fade-in" role="dialog" aria-modal="true" aria-labelledby="matchModalTitle">
        <div class="bg-gradient-to-br from-[#4A0E7B] to-[#1A1F4D] p-8 sm:p-10 rounded-3xl shadow-2xl border border-[#FFD700]/50 text-center relative max-w-sm sm:max-w-md mx-auto transform scale-95 opacity-0 animate-scale-in">
            <button id="closeMatchModalX" class="absolute top-4 right-4 text-white hover:text-[#FFD700] text-2xl" aria-label="Close match dialog">
                <i class="fas fa-times"></i>
            </button>
            <h2 id="matchModalTitle" class="text-4xl font-extrabold text-[#FFD700] mb-4 drop-shadow">¡Es un Match Cósmico!</h2>
            <p class="text-xl text-white mb-6">¡Tú y <span id="matchUserName" class="font-bold text-[#FFD700]"></span> han resonado!</p>
            <img id="matchUserAvatar" src="" alt="Match Avatar" class="w-36 h-36 sm:w-48 sm:h-48 rounded-full mx-auto mb-8 border-5 border-[#FFD700] shadow-xl object-cover ring-4 ring-[#8A2BE2]/50">

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                {{-- Botón "Ver Perfil" eliminado --}}
                <a href="{{ route('chat') }}" id="goToChatBtn" class="inline-flex items-center justify-center px-8 py-4 bg-[#8A2BE2] hover:bg-[#7a1fd1] text-white font-extrabold rounded-full transition duration-300 transform hover:scale-105 shadow-lg text-lg mt-3 sm:mt-0">
                    <i class="fas fa-comments mr-3"></i> Ir al Chat
                </a>
            </div>
        </div>
    </div>

    {{-- Image Lightbox Modal --}}
    <div id="imageLightbox" class="fixed inset-0 bg-black bg-opacity-95 flex items-center justify-center z-[100] p-4 hidden animate-fade-in" role="dialog" aria-modal="true" aria-labelledby="imageLightboxTitle">
        <div class="relative max-w-full max-h-full w-full h-full flex items-center justify-center">
            <button id="closeLightboxBtn" class="absolute top-4 right-4 text-white hover:text-[#FFD700] text-4xl z-10" aria-label="Cerrar visor de imagen">
                <i class="fas fa-times-circle"></i>
            </button>
            <img id="lightboxImage" src="" alt="Imagen de perfil ampliada" class="max-w-[90%] max-h-[90%] object-contain rounded-xl shadow-2xl border-4 border-[#FFD700]/70">
        </div>
    </div>

</section>

@include('partials.desktop-nav')
@include('partials.mobile-nav')

<style>
    /* Ensure content is not hidden by fixed menus */
    @media (max-width: 640px) {
        body {
            padding-bottom: 72px; /* Height of mobile nav bar */
        }
    }
    @media (min-width: 641px) {
        body {
            padding-bottom: 64px; /* Height of desktop fixed menu */
        }
    }

    /* Active icon glow effect */
    .text-[#FFD700] {
        filter: drop-shadow(0 0 6px rgba(255, 215, 0, 0.6));
    }

    /* Card animations */
    @keyframes swipe-left {
        from { transform: translateX(0) rotate(0deg); opacity: 1; }
        to { transform: translateX(-150%) rotate(-30deg); opacity: 0; }
    }

    @keyframes swipe-right {
        from { transform: translateX(0) rotate(0deg); opacity: 1; }
        to { transform: translateX(150%) rotate(30deg); opacity: 0; }
    }

    .animate-swipe-left {
        animation: swipe-left 0.4s ease-out forwards;
    }

    .animate-swipe-right {
        animation: swipe-right 0.4s ease-out forwards;
    }

    .match-card {
        transition: transform 0.3s ease-out, opacity 0.3s ease-out;
        will-change: transform, opacity; /* Optimize for animation */
        min-height: 500px; /* Base height for the card */
        display: flex; /* Ensure flex behavior inside the card */
        flex-direction: column; /* Stack content vertically */
    }

    /* Detailed analysis dropdown styles */
    .collapse-content {
        max-height: 0;
        overflow: hidden; /* Ensures scrollbar is only visible when expanded */
        transition: max-height 0.4s ease-in-out, padding 0.4s ease-in-out;
        padding-top: 0;
        padding-bottom: 0;
    }

    .collapse-content.expanded {
        max-height: 700px; /* Adjusted for potentially more content, allows internal scrolling */
        padding-top: 0.75rem; /* p-3 equivalent */
        padding-bottom: 0.75rem; /* p-3 equivalent */
        overflow-y: auto; /* Enable internal scrolling when expanded */
    }

    .rotate-icon {
        transition: transform 0.3s ease-out;
    }

    .rotate-icon.rotated {
        transform: rotate(180deg);
    }

    /* Custom Scrollbar */
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(255, 215, 0, 0.5);
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 215, 0, 0.7);
    }

    /* Modal Animations */
    @keyframes fade-in {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes scale-in {
        from { transform: scale(0.8) translateY(20px); opacity: 0; }
        to { transform: scale(1) translateY(0); opacity: 1; }
    }

    .animate-fade-in {
        animation: fade-in 0.3s ease-out forwards;
    }

    .animate-scale-in {
        animation: scale-in 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
    }

    /* Floating button animation */
    @keyframes bounce-slow {
        0%, 100% { transform: translateY(0) scale(1); }
        50% { transform: translateY(-5px) scale(1.05); }
    }

    .animate-bounce-slow {
        animation: bounce-slow 2s infinite ease-in-out;
    }

    /* Filter Modal Specific Animations */
    .filter-modal-open {
        transform: translateX(0) !important;
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
        // const viewProfileBtn = document.getElementById('viewProfileBtn'); // Eliminado
        const goToChatBtn = document.getElementById('goToChatBtn'); // Nuevo: Referencia al botón "Ir al Chat"
        const closeMatchModalX = document.getElementById('closeMatchModalX');

        // Elements for image lightbox
        const imageLightbox = document.getElementById('imageLightbox');
        const lightboxImage = document.getElementById('lightboxImage');
        const closeLightboxBtn = document.getElementById('closeLightboxBtn');

        // Elements for filter modal
        const filterBtn = document.getElementById('filterBtn');
        const filterModal = document.getElementById('filterModal');
        const filterModalContent = filterModal.querySelector('div'); // The inner div that slides in
        const closeFilterModalBtn = document.getElementById('closeFilterModalBtn');
        const filterForm = document.getElementById('filterForm');
        const generoFilterSelect = document.getElementById('genero_filter');
        const orientacionSexualFilterSelect = document.getElementById('orientacion_sexual_filter');
        // const tagsContainer = document.getElementById('tagsContainer'); // Eliminado
        const ageMinInput = document.getElementById('age_min');
        const ageMaxInput = document.getElementById('age_max');
        const resetFiltersBtn = document.getElementById('resetFiltersBtn');


        let matches = [];
        let currentMatchIndex = 0;
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let currentFilters = {}; // To store the applied filters

        /**
         * Fetches filter options (genres, orientations) from the API and populates the filter modal.
         * Se ha eliminado la lógica de tags.
         */
        async function fetchFilterOptions() {
            try {
                const response = await fetch('{{ route('matches.filter-options') }}');
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();

                // Populate Genero select
                generoFilterSelect.innerHTML = '<option value="">Todos</option>';
                data.generos.forEach(genero => {
                    const option = document.createElement('option');
                    option.value = genero;
                    option.textContent = genero;
                    generoFilterSelect.appendChild(option);
                });

                // Populate Orientacion Sexual select
                orientacionSexualFilterSelect.innerHTML = '<option value="">Todas</option>';
                data.orientaciones_sexuales.forEach(orientacion => {
                    const option = document.createElement('option');
                    option.value = orientacion;
                    option.textContent = orientacion;
                    orientacionSexualFilterSelect.appendChild(option);
                });

                // Restore selected filters if any
                applyCurrentFiltersToForm();

            } catch (error) {
                console.error('Error fetching filter options:', error);
                // No tagsContainer to update anymore
            }
        }

        /**
         * Fetches potential matches from the API with current filters.
         * @param {Object} filters - Optional filter parameters.
         */
        async function fetchMatches(filters = {}) {
            loadingMessage.classList.remove('hidden');
            noMatchesMessage.classList.add('hidden');
            matchCardContainer.innerHTML = ''; // Clear container

            // Construct query parameters
            const params = new URLSearchParams(filters);
            const queryString = params.toString();
            const url = `{{ route('matches.get') }}${queryString ? `?${queryString}` : ''}`;

            try {
                const response = await fetch(url);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                matches = data.matches;
                currentMatchIndex = 0; // Reset index when new matches are loaded
                displayCurrentMatch();
            } catch (error) {
                console.error('Error fetching matches:', error);
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
         * Displays the current match card or the "no matches" message.
         */
        function displayCurrentMatch() {
            if (matches.length > 0 && currentMatchIndex < matches.length) {
                const match = matches[currentMatchIndex];
                matchCardContainer.innerHTML = createMatchCardHtml(match);
                noMatchesMessage.classList.add('hidden');
                likeBtn.disabled = false;
                dislikeBtn.disabled = false;

                // Add event listener to "Ver Análisis Detallado" button
                const toggleAnalysisBtn = document.getElementById('toggleAnalysisBtn');
                if (toggleAnalysisBtn) {
                    toggleAnalysisBtn.addEventListener('click', function() {
                        const detailedAnalysisContent = document.getElementById('detailedAnalysisContent');
                        const icon = this.querySelector('i');
                        detailedAnalysisContent.classList.toggle('expanded');
                        icon.classList.toggle('rotated');

                        // Update button text based on state
                        if (detailedAnalysisContent.classList.contains('expanded')) {
                            this.innerHTML = 'Ocultar Análisis Detallado <i class="fas fa-chevron-down ml-2 rotate-icon rotated"></i>';
                        } else {
                            this.innerHTML = 'Ver Análisis Detallado <i class="fas fa-chevron-down ml-2 rotate-icon"></i>';
                        }

                        // Scroll the card into view if it expands significantly,
                        // ensuring the user can see the full content
                        if (detailedAnalysisContent.classList.contains('expanded')) {
                            const currentCard = matchCardContainer.querySelector('.match-card');
                            if (currentCard) {
                                currentCard.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                            }
                        }
                    });
                }

                // Add event listeners for additional profile images to open lightbox
                const galleryImages = matchCardContainer.querySelectorAll('.additional-image');
                galleryImages.forEach(img => {
                    img.addEventListener('click', function() {
                        showLightbox(this.src);
                    });
                });

            } else {
                matchCardContainer.innerHTML = '';
                noMatchesMessage.classList.remove('hidden');
                likeBtn.disabled = true;
                dislikeBtn.disabled = true;
            }
        }

        /**
         * Helper function to get the icon and color for an element.
         * @param {string} elemento - The element name (Fuego, Tierra, Aire, Agua).
         * @returns {Object} An object containing the Font Awesome icon class and Tailwind CSS color class.
         */
        function getElementDetails(elemento) {
            let icon = 'fa-question';
            let color = 'text-white';
            switch (elemento) {
                case 'Fuego':
                    icon = 'fa-fire';
                    color = 'text-red-500';
                    break;
                case 'Tierra':
                    icon = 'fa-leaf';
                    color = 'text-green-400';
                    break;
                case 'Aire':
                    icon = 'fa-wind';
                    color = 'text-blue-400';
                    break;
                case 'Agua':
                    icon = 'fa-water';
                    color = 'text-sky-400';
                    break;
            }
            return { icon, color };
        }

        /**
         * Helper function to get the icon and color for a modality.
         * @param {string} modalidad - The modality name (Cardinal, Fijo, Mutable).
         * @returns {Object} An object containing the Font Awesome icon class and Tailwind CSS color class.
         */
        function getModalidadDetails(modalidad) {
            let icon = 'fa-circle';
            let color = 'text-white';
            switch (modalidad) {
                case 'Cardinal':
                    icon = 'fa-compass';
                    color = 'text-red-400';
                    break;
                case 'Fijo':
                    icon = 'fa-anchor';
                    color = 'text-gray-400';
                    break;
                case 'Mutable':
                    icon = 'fa-sync-alt';
                    color = 'text-purple-400';
                    break;
            }
            return { icon, color };
        }

        /**
         * Helper function to format an astrological sign data into the provided HTML structure.
         * @param {Object} signData - Object containing nombre_signo, elemento, modalidad.
         * @param {string} signTypeIcon - Font Awesome icon for the sign type (e.g., 'fa-sun' for solar).
         * @param {string} signTypeText - Text for the sign type title (e.g., 'Signo Solar').
         * @returns {string} HTML string for the astrological sign section.
         */
        function formatAstrologicalSignSection(signData, signTypeIcon, signTypeText) {
            if (!signData || signData.nombre_signo === null || signData.nombre_signo === 'Nada') {
                return `
                    <div class="bg-gradient-to-r from-[#4A0E7B] to-[#1A1F4D] backdrop-blur-sm rounded-2xl p-4 sm:p-6 mb-4 shadow-lg">
                        <div class="flex items-center justify-center mb-4">
                            <h2 class="text-xl sm:text-2xl font-bold flex items-center text-center">
                                <i class="fas ${signTypeIcon} text-[#FFD700] mr-3"></i>
                                ${signTypeText}
                            </h2>
                        </div>
                        <p class="text-[#A7B3EB] text-center mt-2">
                            Datos no disponibles.
                        </p>
                    </div>
                `;
            }

            const signoSlug = signData.nombre_signo ? signData.nombre_signo.toLowerCase() : 'placeholder';
            const elementDetails = getElementDetails(signData.elemento);
            const modalityDetails = getModalidadDetails(signData.modalidad);

            return `
                <div class=" backdrop-blur-sm rounded-2xl p-4 sm:p-6 mb-4 shadow-lg">
                    <div class="flex items-center justify-center mb-4">
                        <h2 class="text-xl sm:text-2xl font-bold flex items-center text-center">
                            <i class="fas ${signTypeIcon} text-[#FFD700] mr-3"></i>
                            ${signTypeText}
                        </h2>
                    </div>

                    <div class="grid grid-cols-3 gap-x-4 sm:gap-x-6 md:gap-x-16 justify-items-center mt-6 md:mt-8">
                        {{-- Columna 1: Signo (Imagen y Nombre) --}}
                        <div class="flex flex-col items-center text-center">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-[#0A0E2A] border-2 border-[#FFD700] flex items-center justify-center mb-2">
                                <img src="{{ asset('images/zodiaco/${signoSlug}.png') }}" onerror="this.onerror=null;this.src='https://placehold.co/80x80/0A0E2A/FFD700?text=${signData.nombre_signo.charAt(0).toUpperCase()}';" alt="${signData.nombre_signo}" class="w-full h-full object-contain p-1">
                            </div>
                            <h4 class="text-base sm:text-lg font-bold text-[#FFD700]">
                                ${signData.nombre_signo}
                            </h4>
                        </div>

                        {{-- Columna 2: Elemento (Icono y Nombre del Elemento) --}}
                        <div class="flex flex-col items-center text-center">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-[#0A0E2A] border-2 border-[#FFD700] flex items-center justify-center mb-2">
                                <i class="fas ${elementDetails.icon} ${elementDetails.color} text-3xl sm:text-4xl"></i>
                            </div>
                            <p class="text-base sm:text-lg font-bold text-[#FFD700]">${signData.elemento}</p>
                        </div>

                        {{-- Columna 3: Modalidad (Icono y Nombre de la Modalidad) --}}
                        <div class="flex flex-col items-center text-center">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-[#0A0E2A] border-2 border-[#FFD700] flex items-center justify-center mb-2">
                                <i class="fas ${modalityDetails.icon} ${modalityDetails.color} text-3xl sm:text-4xl"></i>
                            </div>
                            <p class="text-base sm:text-lg font-bold text-[#FFD700]">${signData.modalidad}</p>
                        </div>
                    </div>
                </div>
            `;
        }

        /**
         * Creates the HTML for a match card.
         * @param {Object} match - The match data.
         * @returns {string} HTML for the card.
         */
        function createMatchCardHtml(match) {
            const photoUrl = match.foto_perfil_url
                ? `{{ asset('${match.foto_perfil_url}') }}` // Ensure asset helper is used correctly
                : `https://placehold.co/180x180/4A0E7B/FFFFFF?text=${match.nombre_completo.charAt(0).toUpperCase()}`;

            let scoreColorClass = 'text-gray-400';
            if (match.puntuacion_general >= 85) {
                scoreColorClass = 'text-green-400'; // High compatibility
            } else if (match.puntuacion_general >= 70) {
                scoreColorClass = 'text-lime-400'; // Good compatibility
            } else if (match.puntuacion_general >= 50) {
                scoreColorClass = 'text-yellow-400'; // Moderate compatibility
            } else if (match.puntuacion_general >= 30) {
                scoreColorClass = 'text-orange-400'; // Low compatibility
            } else {
                scoreColorClass = 'text-red-400'; // Very low compatibility
            }

            const distanceText = match.distancia_km !== null ? `(${match.distancia_km} km)` : '';

            // Generate HTML for each astrological sign section
            const solarSignSection = formatAstrologicalSignSection(match.signos.solar, 'fa-sun', 'Signo Solar');
            const lunarSignSection = formatAstrologicalSignSection(match.signos.lunar, 'fa-moon', 'Signo Lunar');
            const ascendantSignSection = formatAstrologicalSignSection(match.signos.ascendente, 'fa-arrow-up', 'Signo Ascendente');

            // Generate HTML for additional profile images
            let additionalImagesHtml = '';
            if (match.imagenes_perfil && match.imagenes_perfil.length > 0) {
                const imagesGrid = match.imagenes_perfil.map(img => `
                    <div class="relative w-full pb-[100%] rounded-xl overflow-hidden shadow-md border-2 border-[#FFD700]/50 transform hover:scale-105 transition-transform duration-300 cursor-pointer">
                        <img src="{{ asset('${img.url_imagen}') }}" alt="Imagen de perfil de ${match.nombre_completo}" class="additional-image absolute inset-0 w-full h-full object-cover">
                    </div>
                `).join('');

                additionalImagesHtml = `
                    <div class="mt-8 pt-4 border-t border-white/10 w-full text-center">
                        <h3 class="font-semibold text-xl text-[#FFD700] mb-4">Galería de Fotos</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                            ${imagesGrid}
                        </div>
                    </div>
                `;
            }

            return `
                <div id="matchCard-${match.id}" data-match-id="${match.id}" class="match-card bg-gradient-to-br from-[#4A0E7B] to-[#1A1F4D] rounded-3xl shadow-2xl border border-[#FFD700]/40 p-6 sm:p-8 w-full flex flex-col items-center text-white relative overflow-hidden transform transition-transform duration-300">
                    <div class="relative w-full text-center mb-4">
                        <img src="${photoUrl}" alt="${match.nombre_completo}" class="w-36 h-36 sm:w-44 sm:h-44 rounded-full object-cover mx-auto mb-4 border-5 border-[#FFD700] shadow-xl ring-4 ring-[#8A2BE2]/50">
                        <h2 class="text-3xl sm:text-4xl font-bold mb-1 text-[#FFD700] drop-shadow-md">${match.nombre_completo}, ${match.edad}</h2>
                        <p class="text-base sm:text-lg text-[#A7B3EB] mb-1">
                            <i class="fas fa-map-marker-alt mr-2 text-red-400"></i> ${match.lugar_nacimiento} ${distanceText}
                        </p>
                        <p class="text-base sm:text-lg text-[#A7B3EB] mb-4">
                            <i class="fas fa-venus-mars mr-2 text-pink-400"></i> ${match.genero} <i class="fas fa-arrows-alt-h mx-1 text-gray-400"></i> ${match.orientacion_sexual}
                        </p>
                    </div>

                    <div class="bg-black bg-opacity-30 rounded-xl p-4 sm:p-5 w-full mb-4 flex flex-col items-center shadow-inner border border-white/10">
                        <p class="font-semibold text-xl text-white mb-2">
                            Compatibilidad Astrológica: <span class="font-extrabold ${scoreColorClass} text-2xl">${match.puntuacion_general}%</span>
                        </p>
                        <p class="text-sm sm:text-base text-[#E0E7FF] text-center italic mb-3">${match.descripcion_breve}</p>

                        

                        {{-- Collapsible Detailed Analysis --}}
                        <div class="w-full flex justify-center mb-2">
                            <button id="toggleAnalysisBtn" aria-expanded="false" aria-controls="detailedAnalysisContent" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white text-sm px-5 py-2 rounded-full transition duration-300 flex items-center shadow-md">
                                Ver Análisis Detallado <i class="fas fa-chevron-down ml-2 rotate-icon"></i>
                            </button>
                        </div>
                        <div id="detailedAnalysisContent" class="collapse-content text-sm text-[#E0E7FF] text-left w-full rounded-lg border border-white/10 bg-black bg-opacity-20 leading-relaxed custom-scrollbar">
                            <p class="font-semibold text-[#FFD700] mb-2">Análisis Detallado:</p>
                            <p>${match.analisis_detallado}</p>
                        </div>
                    </div>

                    {{-- Astrological Signs Sections (outside collapsible) --}}
                        ${solarSignSection}
                        ${lunarSignSection}
                        ${ascendantSignSection}

                    <p class="text-sm sm:text-base text-[#E0E7FF] text-center mt-auto italic">"${match.biografia || 'Sin biografía disponible.'}"</p>

                    {{-- Additional Profile Images Section --}}
                    ${additionalImagesHtml}
                </div>
            `;
        }

        /**
         * Handles user interaction (like/dislike).
         * @param {string} type - 'like' or 'dislike'.
         */
        async function handleInteraction(type) {
            const currentCard = matchCardContainer.querySelector('.match-card');
            if (!currentCard) return;

            const targetUserId = currentCard.dataset.matchId;
            const targetMatch = matches[currentMatchIndex]; // Get full match object

            // Add animation class
            if (type === 'dislike') {
                currentCard.classList.add('animate-swipe-left');
            } else {
                currentCard.classList.add('animate-swipe-right');
            }

            // Disable buttons to prevent multiple clicks
            likeBtn.disabled = true;
            dislikeBtn.disabled = true;

            // Wait for animation to finish before processing interaction
            currentCard.addEventListener('animationend', async () => {
                try {
                    const response = await fetch(`{{ url('/api/matches') }}/${targetUserId}/interact/${type}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({})
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();
                    console.log(data.message);

                    if (data.is_match) {
                        showMatchModal(targetMatch.nombre_completo, targetMatch.foto_perfil_url, targetUserId);
                    } else {
                        // If no match, simply move to the next profile
                        currentMatchIndex++;
                        displayCurrentMatch();
                    }

                } catch (error) {
                    console.error('Error processing interaction:', error);
                    // Re-enable buttons if interaction fails
                    likeBtn.disabled = false;
                    dislikeBtn.disabled = false;
                    // Optional: Show an error message to the user
                }
            }, { once: true }); // Event listener fires only once
        }

        // Event Listeners for interaction buttons
        likeBtn.addEventListener('click', () => handleInteraction('like'));
        dislikeBtn.addEventListener('click', () => handleInteraction('dislike'));

        // Match Modal functionality
        function showMatchModal(userName, userAvatarUrl, userId) {
            matchUserName.textContent = userName;
            // Use placeholder if no URL or if URL is null/empty
            matchUserAvatar.src = userAvatarUrl ? `{{ asset('${userAvatarUrl}') }}` : `https://placehold.co/180x180/4A0E7B/FFFFFF?text=MATCH`;
            goToChatBtn.href = `{{ url('/chat') }}`; // Set href for 'Ir al Chat' button
            matchModal.classList.remove('hidden');
            // Add animation classes
            matchModal.classList.add('animate-fade-in');
            matchModal.querySelector('div').classList.add('animate-scale-in');
        }

        // Close modal when clicking 'X' button or outside (optional)
        closeMatchModalX.addEventListener('click', () => {
            matchModal.classList.add('hidden');
            // Remove animation classes for next time
            matchModal.classList.remove('animate-fade-in');
            matchModal.querySelector('div').classList.remove('animate-scale-in');
            // Proceed to the next match after closing modal
            currentMatchIndex++;
            displayCurrentMatch();
        });

        // Lightbox functionality
        function showLightbox(imageUrl) {
            lightboxImage.src = imageUrl;
            imageLightbox.classList.remove('hidden');
            // Add animation classes
            imageLightbox.classList.add('animate-fade-in');
        }

        closeLightboxBtn.addEventListener('click', () => {
            imageLightbox.classList.add('hidden');
            imageLightbox.classList.remove('animate-fade-in');
        });

        imageLightbox.addEventListener('click', function(event) {
            if (event.target === imageLightbox) { // Only close if clicked directly on the overlay
                imageLightbox.classList.add('hidden');
                imageLightbox.classList.remove('animate-fade-in');
            }
        });

        // Filter Modal Functions
        filterBtn.addEventListener('click', () => {
            filterModal.classList.remove('hidden');
            setTimeout(() => {
                filterModalContent.classList.add('filter-modal-open');
            }, 10); // Small delay to allow 'hidden' to be removed first
        });

        closeFilterModalBtn.addEventListener('click', () => {
            filterModalContent.classList.remove('filter-modal-open');
            filterModalContent.addEventListener('transitionend', () => {
                filterModal.classList.add('hidden');
            }, { once: true });
        });

        filterModal.addEventListener('click', (event) => {
            // Close if clicking outside the content area
            if (event.target === filterModal) {
                filterModalContent.classList.remove('filter-modal-open');
                filterModalContent.addEventListener('transitionend', () => {
                    filterModal.classList.add('hidden');
                }, { once: true });
            }
        });

        filterForm.addEventListener('submit', (event) => {
            event.preventDefault(); // Prevent default form submission

            const filters = {};
            const formData = new FormData(filterForm);

            // Get age filters
            const ageMin = formData.get('age_min');
            const ageMax = formData.get('age_max');
            if (ageMin) filters.age_min = ageMin;
            if (ageMax) filters.age_max = ageMax;

            // Get gender filter
            const genero = formData.get('genero');
            if (genero) filters.genero = genero;

            // Get sexual orientation filter
            const orientacionSexual = formData.get('orientacion_sexual');
            if (orientacionSexual) filters.orientacion_sexual = orientacionSexual;

            // Se ha eliminado la lógica de tags

            currentFilters = filters; // Store current filters
            fetchMatches(currentFilters); // Fetch matches with new filters
            closeFilterModalBtn.click(); // Close the modal
        });

        resetFiltersBtn.addEventListener('click', () => {
            filterForm.reset(); // Reset form fields
            currentFilters = {}; // Clear stored filters
            fetchMatches(currentFilters); // Fetch matches without filters
            closeFilterModalBtn.click(); // Close the modal
        });

        /**
         * Applies the currently stored filters to the form elements when the modal opens.
         * Se ha eliminado la lógica de tags.
         */
        function applyCurrentFiltersToForm() {
            if (currentFilters.age_min) ageMinInput.value = currentFilters.age_min; else ageMinInput.value = '';
            if (currentFilters.age_max) ageMaxInput.value = currentFilters.age_max; else ageMaxInput.value = '';
            if (currentFilters.genero) generoFilterSelect.value = currentFilters.genero; else generoFilterSelect.value = '';
            if (currentFilters.orientacion_sexual) orientacionSexualFilterSelect.value = currentFilters.orientacion_sexual; else orientacionSexualFilterSelect.value = '';

            // Se ha eliminado la lógica de tags
        }


        // Initial load
        fetchMatches(); // Initial fetch without filters
        fetchFilterOptions(); // Populate filter modal options
    });
</script>
@endsection
