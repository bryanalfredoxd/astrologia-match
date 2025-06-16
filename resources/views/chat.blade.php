@extends('layouts.app_sesion')

@section('content')

<section class="bg-[#0A0E2A] text-white min-h-screen py-10 px-4 sm:px-6 relative overflow-hidden flex">
    <div class="flex h-full w-full overflow-hidden rounded-2xl backdrop-blur-md shadow-xl border border-[#4A0E7B] border-opacity-40">

        <!-- LADO IZQUIERDO: LISTA DE MATCHES (CHAT LIST) -->
        <div id="chatList" class="w-full md:w-1/4 border-r border-white/10 bg-white bg-opacity-5 flex flex-col">
            <div class="p-4 font-bold text-xl border-b border-white/10 text-[#FFD700]">Chats</div>
            <div id="matchesListContainer" class="overflow-y-auto flex-1 custom-scrollbar">
                {{-- Matches se cargarán aquí dinámicamente --}}
                <p id="loadingChatsMessage" class="p-4 text-[#A7B3EB] text-center">Cargando chats...</p>
                <p id="noChatsMessage" class="p-4 text-[#A7B3EB] text-center hidden">No tienes matches activos para chatear.</p>
            </div>
        </div>

        <!-- LADO DERECHO: CHAT AREA -->
        <div id="chatArea" class="hidden flex flex-col w-full md:flex-1 h-full">

            <!-- HEADER DEL CHAT ACTIVO -->
            <div id="chatHeader" class="bg-white bg-opacity-10 backdrop-blur-md shadow-md p-4 flex items-center justify-start border-b border-white/10">
                {{-- Contenido del header se inyectará aquí --}}
                <p class="text-sm text-[#A7B3EB] italic w-full text-center">Selecciona un contacto</p>
            </div>

            <!-- MENSAJES DEL CHAT -->
            <div id="chatMessages" class="flex-1 overflow-y-auto px-4 py-6 space-y-4 custom-scrollbar">
                <p id="selectMatchMessage" class="text-[#A7B3EB] italic text-center text-lg">Selecciona un match para comenzar a chatear</p>
                {{-- Mensajes se cargarán aquí dinámicamente --}}
            </div>

            <!-- INPUT DE MENSAJE -->
            <form id="messageForm" class="bg-white bg-opacity-10 backdrop-blur-md px-4 py-3 flex items-center space-x-3 border-t border-white/10">
                <button type="button" id="emojiToggleBtn" class="text-white text-2xl hover:text-yellow-300 transition-colors"><i class="fa-regular fa-face-smile"></i></button>
                <input id="messageInput" type="text" placeholder="Escribe un mensaje..." class="flex-1 px-4 py-2 rounded-full text-gray-900 focus:outline-none bg-white bg-opacity-80" disabled>
                <button type="submit" id="sendMessageBtn" class="bg-purple-600 text-white rounded-full px-5 py-2 hover:bg-purple-700 transition" disabled><i class="fa-solid fa-paper-plane"></i></button>
            </form>

            <!-- PANEL DE EMOJIS -->
            <div id="emojiPanel" class="hidden fixed bottom-24 left-1/2 transform -translate-x-1/2 bg-white text-gray-900 p-2 rounded-lg shadow-xl text-xl z-50 border border-gray-300 grid grid-cols-6 gap-2 sm:grid-cols-8 md:grid-cols-10 max-w-xs sm:max-w-md">
                {{-- Emojis se cargarán dinámicamente --}}
            </div>
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

    /* Estilos de scrollbar personalizados */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: rgba(255,255,255,0.3);
        border-radius: 3px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background-color: rgba(255,255,255,0.1);
        border-radius: 3px;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const matchesListContainer = document.getElementById('matchesListContainer');
        const loadingChatsMessage = document.getElementById('loadingChatsMessage');
        const noChatsMessage = document.getElementById('noChatsMessage');
        const chatArea = document.getElementById('chatArea');
        const chatList = document.getElementById('chatList');
        const chatHeader = document.getElementById('chatHeader');
        const chatMessages = document.getElementById('chatMessages');
        const messageInput = document.getElementById('messageInput');
        const sendMessageBtn = document.getElementById('sendMessageBtn');
        const emojiToggleBtn = document.getElementById('emojiToggleBtn');
        const emojiPanel = document.getElementById('emojiPanel');
        const selectMatchMessage = document.getElementById('selectMatchMessage');

        let activeMatches = [];
        let currentChatTargetId = null;
        let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const currentUserId = {{ Auth::id() }}; // Obtener el ID del usuario actual de Blade

        // Emojis para el panel
        const emojis = ['😀', '😁', '😂', '🤣', '😊', '😍', '😎', '🤩', '😘', '😢', '😡', '😱', '🙌', '🙏', '💖', '🎉', '❤️', '👍', '👎', '👏', '🔥', '✨', '🌟', '🚀', '🌌', '🌠', '💫', '🎶', '🎵', '💯', '✅', '❌', '❤️‍🔥', '🤔', '💬', '👀', '🤙', '👋', '🤞', '✌️', '🖖', '💪', '🧠', '💡', '💬', '🗣️', '💖', '💞', '💕', '🧡', '💛', '💚', '💙', '💜', '🤎', '🖤', '🤍', '💔', '❤️‍🩹'];

        // --- Funciones de Carga de Datos ---

        /**
         * Carga la lista de matches activos del usuario.
         */
        async function fetchActiveMatches() {
            loadingChatsMessage.classList.remove('hidden');
            noChatsMessage.classList.add('hidden');
            matchesListContainer.innerHTML = ''; // Limpiar lista antes de cargar

            try {
                const response = await fetch('{{ route('chats.get_active_matches') }}');
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                activeMatches = data.matches;
                displayActiveMatches();
            } catch (error) {
                console.error('Error al cargar matches activos:', error);
                loadingChatsMessage.textContent = 'Error al cargar chats. Por favor, intenta de nuevo.';
            } finally {
                loadingChatsMessage.classList.add('hidden');
            }
        }

        /**
         * Muestra los matches activos en la lista de chats.
         */
        function displayActiveMatches() {
            if (activeMatches.length === 0) {
                noChatsMessage.classList.remove('hidden');
                return;
            }

            activeMatches.forEach(match => {
                const photoUrl = match.foto_perfil_url
                    ? `{{ asset('') }}${match.foto_perfil_url}`
                    : `https://placehold.co/40x40/4A0E7B/FFFFFF?text=${match.nombre_completo.charAt(0).toUpperCase()}`;

                const lastMessageContent = match.last_message ? match.last_message.contenido : 'Comienza la conversación...';
                const unreadBadge = match.unread_messages > 0 ? `<span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full absolute top-1 right-1">${match.unread_messages}</span>` : '';

                const chatItem = document.createElement('div');
                chatItem.dataset.userId = match.id;
                chatItem.dataset.userName = match.nombre_completo;
                chatItem.dataset.userAvatar = photoUrl;
                chatItem.className = 'cursor-pointer flex items-center space-x-3 px-4 py-3 hover:bg-white hover:bg-opacity-10 transition relative';
                chatItem.innerHTML = `
                    <img src="${photoUrl}" class="w-12 h-12 rounded-full object-cover" alt="Avatar de ${match.nombre_completo}">
                    <div class="flex-1 overflow-hidden">
                        <h3 class="font-semibold text-lg text-white truncate">${match.nombre_completo}</h3>
                        <p class="text-sm text-[#A7B3EB] truncate">${lastMessageContent}</p>
                    </div>
                    ${unreadBadge}
                `;
                chatItem.addEventListener('click', () => seleccionarChat(match.id, match.nombre_completo, photoUrl));
                matchesListContainer.appendChild(chatItem);
            });
        }

        /**
         * Carga y muestra los mensajes para un chat específico.
         * @param {number} targetUserId
         */
        async function fetchMessages(targetUserId) {
            chatMessages.innerHTML = '<p class="text-[#A7B3EB] italic text-center">Cargando mensajes...</p>';
            selectMatchMessage.classList.add('hidden'); // Ocultar mensaje de "seleccionar match"

            try {
                const response = await fetch(`{{ url('/api/chats/messages') }}/${targetUserId}`);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                const data = await response.json();
                renderMessages(data.messages);
            } catch (error) {
                console.error('Error al cargar mensajes:', error);
                chatMessages.innerHTML = '<p class="text-red-400 italic text-center">Error al cargar mensajes.</p>';
            }
        }

        /**
         * Renderiza los mensajes en el área de chat.
         * @param {Array} messages
         */
        function renderMessages(messages) {
            chatMessages.innerHTML = ''; // Limpiar mensajes existentes
            if (messages.length === 0) {
                chatMessages.innerHTML = '<p class="text-[#A7B3EB] italic text-center text-lg">¡Es el inicio de su conversación!</p>';
                return;
            }

            messages.forEach(msg => {
                const isMe = msg.id_remitente === currentUserId;
                const messageClass = isMe ? 'justify-end' : 'justify-start';
                const bubbleClass = isMe ? 'bg-purple-600' : 'bg-white bg-opacity-10';
                const textColorClass = isMe ? 'text-white' : 'text-white'; // Todos los mensajes serán blancos

                const photoUrl = isMe
                    ? `{{ Auth::user()->foto_perfil_url ? asset(Auth::user()->foto_perfil_url) : 'https://placehold.co/40x40/4A0E7B/FFFFFF?text=' . strtoupper(substr(Auth::user()->nombre_completo, 0, 1)) }}`
                    : matchesListContainer.querySelector(`[data-user-id="${msg.id_remitente}"]`)?.dataset.userAvatar;


                const msgElement = document.createElement('div');
                msgElement.className = `flex ${messageClass} items-end space-x-2`;
                msgElement.innerHTML = `
                    ${!isMe ? `<img src="${photoUrl}" class="rounded-full w-8 h-8 object-cover" alt="Avatar">` : ''}
                    <div class="${bubbleClass} rounded-2xl p-3 max-w-xs md:max-w-md ${textColorClass}">
                        <p>${msg.contenido}</p>
                        <span class="text-xs ${isMe ? 'text-purple-200' : 'text-[#A7B3EB]'} block mt-1 text-right">${formatTime(msg.fecha_envio)}</span>
                    </div>
                    ${isMe ? `<img src="${photoUrl}" class="rounded-full w-8 h-8 object-cover" alt="Avatar">` : ''}
                `;
                chatMessages.appendChild(msgElement);
            });
            chatMessages.scrollTop = chatMessages.scrollHeight; // Scroll al final
        }

        // --- Lógica de Interfaz de Usuario ---

        /**
         * Selecciona un chat y carga sus mensajes.
         * @param {number} userId - ID del usuario con quien chatear.
         * @param {string} userName - Nombre del usuario.
         * @param {string} userAvatar - URL del avatar del usuario.
         */
        function seleccionarChat(userId, userName, userAvatar) {
            currentChatTargetId = userId;
            chatArea.classList.remove('hidden');
            selectMatchMessage.classList.add('hidden'); // Ocultar el mensaje "Selecciona un match"

            // Oculta lista en móvil si la pantalla es pequeña
            if (window.innerWidth < 768) {
                chatList.classList.add('hidden');
            }

            messageInput.removeAttribute('disabled');
            sendMessageBtn.removeAttribute('disabled');
            messageInput.focus();

            // Actualizar el header del chat
            chatHeader.className = 'bg-white bg-opacity-10 backdrop-blur-md shadow-md p-4 flex items-center justify-start border-b border-white/10';
            chatHeader.innerHTML = `
                <div class="flex items-center space-x-3 w-full">
                    <button onclick="volverALista()" class="text-xl md:hidden text-white hover:text-yellow-300 transition-colors"><i class="fa-solid fa-arrow-left"></i></button>
                    <img src="${userAvatar}" class="rounded-full w-10 h-10 object-cover" alt="Avatar de ${userName}">
                    <div class="truncate">
                        <h2 class="text-lg font-semibold text-white truncate">${userName}</h2>
                        <p class="text-sm text-[#A7B3EB]">En línea</p>
                    </div>
                </div>
            `;

            // Cargar mensajes para el chat seleccionado
            fetchMessages(userId);

            // Eliminar la burbuja de no leídos de la lista
            const chatItem = matchesListContainer.querySelector(`[data-user-id="${userId}"]`);
            if (chatItem) {
                const unreadBadge = chatItem.querySelector('.bg-red-500');
                if (unreadBadge) unreadBadge.remove();
            }
        }

        /**
         * Vuelve a la lista de chats en móviles.
         */
        window.volverALista = function() { // Hacerla global para que pueda ser llamada desde el onclick
            chatArea.classList.add('hidden');
            chatList.classList.remove('hidden');
            currentChatTargetId = null; // Resetear el target ID
            chatMessages.innerHTML = ''; // Limpiar mensajes
            selectMatchMessage.classList.remove('hidden'); // Mostrar mensaje de seleccionar match
            messageInput.setAttribute('disabled', 'disabled');
            sendMessageBtn.setAttribute('disabled', 'disabled');
            emojiPanel.classList.add('hidden'); // Ocultar panel de emojis
        };

        // --- Lógica de Mensajes ---

        /**
         * Envía un nuevo mensaje.
         */
        document.getElementById('messageForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const contenido = messageInput.value.trim();

            if (contenido === '' || currentChatTargetId === null) {
                return;
            }

            sendMessageBtn.disabled = true; // Deshabilitar para evitar spam

            try {
                const response = await fetch('{{ route('chats.send_message') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        id_receptor: currentChatTargetId,
                        contenido: contenido
                    })
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    console.error('Error al enviar mensaje:', errorData.message || response.statusText);
                    alert('Error al enviar mensaje: ' + (errorData.message || 'Verifica tu conexión.')); // Usar alert temporal, reemplazar con modal
                    return;
                }

                const data = await response.json();
                // Renderizar el mensaje enviado en la interfaz
                renderSingleMessage(data.data, true); // True indica que es mi mensaje
                messageInput.value = ''; // Limpiar el input
                chatMessages.scrollTop = chatMessages.scrollHeight; // Scroll al final
                // Opcional: Recargar la lista de matches para actualizar el último mensaje
                // fetchActiveMatches();

            } catch (error) {
                console.error('Error de red al enviar mensaje:', error);
                alert('No se pudo conectar al servidor para enviar el mensaje.'); // Usar alert temporal
            } finally {
                sendMessageBtn.disabled = false; // Re-habilitar
            }
        });

        /**
         * Renderiza un solo mensaje (útil para el mensaje propio recién enviado).
         * @param {object} msg - Objeto del mensaje.
         * @param {boolean} isMe - True si es un mensaje del usuario actual.
         */
        function renderSingleMessage(msg, isMe) {
            const messageClass = isMe ? 'justify-end' : 'justify-start';
            const bubbleClass = isMe ? 'bg-purple-600' : 'bg-white bg-opacity-10';
            const textColorClass = isMe ? 'text-white' : 'text-white';

            const photoUrl = isMe
                ? `{{ Auth::user()->foto_perfil_url ? asset(Auth::user()->foto_perfil_url) : 'https://placehold.co/40x40/4A0E7B/FFFFFF?text=' . strtoupper(substr(Auth::user()->nombre_completo, 0, 1)) }}`
                : matchesListContainer.querySelector(`[data-user-id="${msg.id_remitente}"]`)?.dataset.userAvatar;

            const msgElement = document.createElement('div');
            msgElement.className = `flex ${messageClass} items-end space-x-2`;
            msgElement.innerHTML = `
                ${!isMe ? `<img src="${photoUrl}" class="rounded-full w-8 h-8 object-cover" alt="Avatar">` : ''}
                <div class="${bubbleClass} rounded-2xl p-3 max-w-xs md:max-w-md ${textColorClass}">
                    <p>${msg.contenido}</p>
                    <span class="text-xs ${isMe ? 'text-purple-200' : 'text-[#A7B3EB]'} block mt-1 text-right">${formatTime(msg.fecha_envio)}</span>
                </div>
                ${isMe ? `<img src="${photoUrl}" class="rounded-full w-8 h-8 object-cover" alt="Avatar">` : ''}
            `;
            chatMessages.appendChild(msgElement);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }


        // --- Lógica de Emojis ---

        /**
         * Inicializa el panel de emojis.
         */
        function initEmojiPanel() {
            emojiPanel.innerHTML = ''; // Limpiar cualquier contenido anterior
            emojis.forEach(emoji => {
                const span = document.createElement('span');
                span.textContent = emoji;
                span.className = 'cursor-pointer hover:bg-gray-100 rounded p-1 transition-colors';
                span.addEventListener('click', () => {
                    messageInput.value += emoji;
                    messageInput.focus();
                    emojiPanel.classList.add('hidden');
                });
                emojiPanel.appendChild(span);
            });
        }

        emojiToggleBtn.addEventListener('click', () => {
            emojiPanel.classList.toggle('hidden');
        });

        // Ocultar panel de emojis si se hace clic fuera
        document.addEventListener('click', (event) => {
            if (!emojiPanel.contains(event.target) && event.target !== emojiToggleBtn && !emojiToggleBtn.contains(event.target)) {
                emojiPanel.classList.add('hidden');
            }
        });


        // --- Helpers ---

        /**
         * Formatea la hora de un timestamp.
         * @param {string} datetimeString - Timestamp de la base de datos.
         * @returns {string} Hora formateada (ej. "10:30 AM").
         */
        function formatTime(datetimeString) {
            const date = new Date(datetimeString);
            const options = { hour: '2-digit', minute: '2-digit', hour12: true };
            return date.toLocaleTimeString('es-ES', options);
        }

        // --- Inicialización ---

        fetchActiveMatches(); // Cargar los matches al cargar la página
        initEmojiPanel(); // Inicializar el panel de emojis
    });
</script>
@endsection
