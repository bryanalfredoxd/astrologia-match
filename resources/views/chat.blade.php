@extends('layouts.app_sesion')

@section('content')

<section class="bg-[#0A0E2A] text-white min-h-screen py-10 px-4 sm:px-6 relative overflow-hidden flex flex-col">
    <div class="flex flex-1 w-full overflow-hidden rounded-2xl backdrop-blur-md shadow-xl border border-[#4A0E7B] border-opacity-40">

        <div id="chatList" class="w-full md:w-1/4 border-r border-white/10 bg-white bg-opacity-5 flex flex-col">
            <div class="p-4 font-bold text-xl border-b border-white/10 text-[#FFD700]">Chats</div>
            <div id="matchesListContainer" class="overflow-y-auto flex-1 custom-scrollbar">
                <p id="noChatsMessage" class="p-4 text-[#A7B3EB] text-center hidden">No tienes matches activos para chatear.</p>
            </div>
        </div>

        <div id="chatArea" class="flex-col w-full md:flex-1 h-full hidden md:flex">

            <div id="chatHeader" class="bg-white bg-opacity-10 backdrop-blur-md shadow-md p-4 flex items-center justify-start border-b border-white/10">
                <p id="chatHeaderPlaceholder" class="text-sm text-[#A7B3EB] italic w-full text-center">Selecciona un contacto</p>
            </div>

            <div id="chatMessages" class="flex-1 overflow-y-auto px-4 py-6 space-y-4 custom-scrollbar">
                <p id="selectMatchMessage" class="text-[#A7B3EB] italic text-center text-lg">Selecciona un match para comenzar a chatear</p>
            </div>

            <form id="messageForm" class="bg-white bg-opacity-10 backdrop-blur-md px-4 py-3 flex items-center space-x-3 border-t border-white/10">
                {{-- ELIMINADO: <button type="button" id="emojiToggleBtn" class="text-white text-2xl hover:text-yellow-300 transition-colors"><i class="fa-regular fa-face-smile"></i></button> --}}
                <input id="messageInput" type="text" placeholder="Escribe un mensaje..." class="flex-1 px-4 py-2 rounded-full text-gray-900 focus:outline-none bg-white bg-opacity-80" disabled>
                <button type="submit" id="sendMessageBtn" class="bg-purple-600 text-white rounded-full px-5 py-2 hover:bg-purple-700 transition" disabled><i class="fa-solid fa-paper-plane"></i></button>
            </form>

            {{-- ELIMINADO: <div id="emojiPanel" class="hidden fixed bottom-24 left-1/2 transform -translate-x-1/2 bg-white text-gray-900 p-2 rounded-lg shadow-xl text-xl z-50 border border-gray-300 grid grid-cols-6 gap-2 sm:grid-cols-8 md:grid-cols-10 max-w-xs sm:max-w-md"></div> --}}
        </div>
    </div>

    <div class="absolute top-0 left-0 w-48 h-48 bg-[#4A0E7B] rounded-full mix-blend-screen opacity-10 blur-3xl animate-blob -z-10"></div>
    <div class="absolute bottom-0 right-0 w-48 h-48 bg-[#8A2BE2] rounded-full mix-blend-screen opacity-10 blur-3xl animate-blob animation-delay-2000 -z-10"></div>
    <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-[#FFD700] rounded-full mix-blend-screen opacity-5 blur-3xl animate-blob animation-delay-4000 -z-10"></div>
</section>

@include('partials.desktop-nav')
@include('partials.mobile-nav')

<style>
    @media (max-width: 640px) {
        body {
            padding-bottom: 72px;
        }
    }
    @media (min-width: 641px) {
        body {
            padding-bottom: 64px;
        }
    }
    .text-[#FFD700] {
        filter: drop-shadow(0 0 4px rgba(255, 215, 0, 0.4));
    }
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
    document.addEventListener('DOMContentLoaded', () => {
        const els = {
            matchesListContainer: document.getElementById('matchesListContainer'),
            noChatsMessage: document.getElementById('noChatsMessage'),
            chatArea: document.getElementById('chatArea'),
            chatList: document.getElementById('chatList'),
            chatHeader: document.getElementById('chatHeader'),
            chatHeaderPlaceholder: document.getElementById('chatHeaderPlaceholder'),
            chatMessages: document.getElementById('chatMessages'),
            messageInput: document.getElementById('messageInput'),
            sendMessageBtn: document.getElementById('sendMessageBtn'),
            // ELIMINADO: emojiToggleBtn: document.getElementById('emojiToggleBtn'),
            // ELIMINADO: emojiPanel: document.getElementById('emojiPanel'),
            selectMatchMessage: document.getElementById('selectMatchMessage'),
            messageForm: document.getElementById('messageForm'),
        };

        let currentChatTargetId = null;
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const currentUserId = {{ Auth::id() }};

        // ELIMINADO: const emojis = ['😀', '😁', ...];

        const getUserAvatar = (user) => user.foto_perfil_url
            ? `{{ asset('') }}${user.foto_perfil_url}`
            : `https://placehold.co/40x40/4A0E7B/FFFFFF?text=${user.nombre_completo.charAt(0).toUpperCase()}`;

        const formatTime = (datetimeString) => {
            const date = new Date(datetimeString);
            return date.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit', hour12: true });
        };

        let activeMatches = [];
        let lastMessageTimestamp = {};
        let pollInterval;
        let unreadPollInterval;

        const updateOrCreateChatItem = (match) => {
            const photoUrl = getUserAvatar(match);
            const lastMessageContent = match.last_message ? match.last_message.contenido : 'Comienza la conversación...';
            const unreadCount = match.unread_messages || 0;

            let chatItem = els.matchesListContainer.querySelector(`[data-user-id="${match.id}"]`);

            if (chatItem) {
                const imgElement = chatItem.querySelector('img');
                const nameElement = chatItem.querySelector('h3');
                const lastMessageElement = chatItem.querySelector('p');
                let unreadBadge = chatItem.querySelector('.unread-badge');

                if (imgElement && imgElement.src !== photoUrl) {
                    imgElement.src = photoUrl;
                }
                if (nameElement && nameElement.textContent !== match.nombre_completo) {
                    nameElement.textContent = match.nombre_completo;
                }
                if (lastMessageElement && lastMessageElement.textContent !== lastMessageContent) {
                    lastMessageElement.textContent = lastMessageContent;
                }

                if (unreadCount > 0) {
                    if (!unreadBadge) {
                        unreadBadge = document.createElement('span');
                        unreadBadge.className = 'unread-badge bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full absolute top-1 right-1';
                        chatItem.appendChild(unreadBadge);
                    }
                    unreadBadge.textContent = unreadCount;
                    unreadBadge.classList.remove('hidden');
                } else {
                    if (unreadBadge) {
                        unreadBadge.classList.add('hidden');
                    }
                }
            } else {
                chatItem = document.createElement('div');
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
                    ${unreadCount > 0 ? `<span class="unread-badge bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full absolute top-1 right-1">${unreadCount}</span>` : `<span class="unread-badge hidden bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full absolute top-1 right-1"></span>`}
                `;
                chatItem.addEventListener('click', () => seleccionarChat(match.id, match.nombre_completo, photoUrl));
                els.matchesListContainer.appendChild(chatItem);
            }
        };

        const fetchActiveMatches = async () => {
            try {
                const response = await fetch('{{ route('chats.get_active_matches') }}');
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                const data = await response.json();

                const newActiveMatches = data.matches;
                const existingChatIds = new Set(Array.from(els.matchesListContainer.children).map(el => el.dataset.userId));
                const newChatIds = new Set(newActiveMatches.map(match => match.id.toString()));

                newActiveMatches.forEach(match => {
                    updateOrCreateChatItem(match);
                });

                existingChatIds.forEach(id => {
                    if (!newChatIds.has(id)) {
                        const chatItemToRemove = els.matchesListContainer.querySelector(`[data-user-id="${id}"]`);
                        if (chatItemToRemove) {
                            chatItemToRemove.remove();
                        }
                    }
                });

                activeMatches = newActiveMatches;

                if (activeMatches.length === 0) {
                    els.noChatsMessage.classList.remove('hidden');
                } else {
                    els.noChatsMessage.classList.add('hidden');
                }

            } catch (error) {
                console.error('Error al cargar matches activos:', error);
            }
        };

        const fetchMessages = async (targetUserId, appendOnly = false) => {
            if (!appendOnly) {
                els.chatMessages.innerHTML = '<p class="text-[#A7B3EB] italic text-center">Cargando mensajes...</p>';
                els.selectMatchMessage.classList.add('hidden');
            }

            try {
                const response = await fetch(`{{ url('/api/chats/messages') }}/${targetUserId}`);
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                const data = await response.json();

                const newMessages = [];
                data.messages.forEach(msg => {
                    const msgTimestamp = new Date(msg.fecha_envio).getTime();
                    if (!appendOnly || !lastMessageTimestamp[targetUserId] || msgTimestamp > lastMessageTimestamp[targetUserId]) {
                        newMessages.push(msg);
                    }
                });

                if (!appendOnly) {
                    renderMessages(data.messages);
                } else if (newMessages.length > 0) {
                    newMessages.forEach(msg => renderSingleMessage(msg, msg.id_remitente === currentUserId));
                    if (els.chatMessages.scrollHeight - els.chatMessages.scrollTop <= els.chatMessages.clientHeight + 50) {
                        els.chatMessages.scrollTop = els.chatMessages.scrollHeight;
                    }
                }

                if (data.messages.length > 0) {
                    lastMessageTimestamp[targetUserId] = new Date(data.messages[data.messages.length - 1].fecha_envio).getTime();
                }

            } catch (error) {
                console.error('Error al cargar mensajes:', error);
                if (!appendOnly) {
                    els.chatMessages.innerHTML = '<p class="text-red-400 italic text-center">Error al cargar mensajes.</p>';
                }
            }
        };

        const renderMessages = (messages) => {
            els.chatMessages.innerHTML = '';
            if (messages.length === 0) {
                els.chatMessages.innerHTML = '<p class="text-[#A7B3EB] italic text-center text-lg">¡Es el inicio de su conversación!</p>';
                return;
            }

            messages.forEach(msg => renderSingleMessage(msg, msg.id_remitente === currentUserId));
            els.chatMessages.scrollTop = els.chatMessages.scrollHeight;
        };

        const renderSingleMessage = (msg, isMe) => {
            const messageClass = isMe ? 'justify-end' : 'justify-start';
            const bubbleClass = isMe ? 'bg-purple-600' : 'bg-white bg-opacity-10';
            const textColorClass = 'text-white';

            let photoUrl;
            if (isMe) {
                photoUrl = `{{ Auth::user()->foto_perfil_url ? asset(Auth::user()->foto_perfil_url) : 'https://placehold.co/40x40/4A0E7B/FFFFFF?text=' . strtoupper(substr(Auth::user()->nombre_completo, 0, 1)) }}`;
            } else {
                const matchUser = activeMatches.find(match => match.id === msg.id_remitente);
                photoUrl = matchUser ? getUserAvatar(matchUser) : `https://placehold.co/40x40/4A0E7B/FFFFFF?text=U`;
            }

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
            els.chatMessages.appendChild(msgElement);
        };

        const seleccionarChat = (userId, userName, userAvatar) => {
            currentChatTargetId = userId;
            els.selectMatchMessage.classList.add('hidden');
            if (els.chatHeaderPlaceholder) els.chatHeaderPlaceholder.classList.add('hidden');

            if (window.innerWidth < 768) {
                els.chatList.classList.add('hidden');
                els.chatArea.classList.remove('hidden');
                els.chatArea.classList.add('flex');
            }

            els.messageInput.removeAttribute('disabled');
            els.sendMessageBtn.removeAttribute('disabled');
            els.messageInput.focus();

            els.chatHeader.className = 'bg-white bg-opacity-10 backdrop-blur-md shadow-md p-4 flex items-center justify-start border-b border-white/10';
            els.chatHeader.innerHTML = `
                <div class="flex items-center space-x-3 w-full">
                    <button onclick="volverALista()" class="text-xl md:hidden text-white hover:text-yellow-300 transition-colors"><i class="fa-solid fa-arrow-left"></i></button>
                    <img src="${userAvatar}" class="rounded-full w-10 h-10 object-cover" alt="Avatar de ${userName}">
                    <div class="truncate">
                        <h2 class="text-lg font-semibold text-white truncate">${userName}</h2>
                        <p class="text-sm text-[#A7B3EB]">En línea</p>
                    </div>
                </div>
            `;
            fetchMessages(userId);
            markMessagesAsRead(userId);

            const chatItem = els.matchesListContainer.querySelector(`[data-user-id="${userId}"]`);
            if (chatItem) {
                const unreadBadge = chatItem.querySelector('.unread-badge');
                if (unreadBadge) {
                    unreadBadge.classList.add('hidden');
                    unreadBadge.textContent = '0';
                }
            }

            startPolling();
        };

        const markMessagesAsRead = async (userId) => {
            try {
                const response = await fetch(`{{ url('/api/chats/mark-as-read') }}/${userId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                });
                if (!response.ok) {
                    console.error('Error al marcar mensajes como leídos:', await response.text());
                } else {
                    console.log(`Mensajes con ${userId} marcados como leídos.`);
                }
            } catch (error) {
                console.error('Error de red al marcar mensajes como leídos:', error);
            }
        };

        window.volverALista = () => {
            currentChatTargetId = null;
            els.chatMessages.innerHTML = '';
            els.selectMatchMessage.classList.remove('hidden');
            if (els.chatHeaderPlaceholder) els.chatHeaderPlaceholder.classList.remove('hidden');
            els.chatHeader.innerHTML = `<p id="chatHeaderPlaceholder" class="text-sm text-[#A7B3EB] italic w-full text-center">Selecciona un contacto</p>`;
            els.messageInput.setAttribute('disabled', 'disabled');
            els.sendMessageBtn.setAttribute('disabled', 'disabled');
            // ELIMINADO: els.emojiPanel.classList.add('hidden');
            stopPolling();

            if (window.innerWidth < 768) {
                els.chatList.classList.remove('hidden');
                els.chatArea.classList.add('hidden');
                els.chatArea.classList.remove('flex');
            }
        };

        els.messageForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const contenido = els.messageInput.value.trim();

            if (contenido === '' || currentChatTargetId === null) return;

            els.sendMessageBtn.disabled = true;

            try {
                const response = await fetch('{{ route('chats.send_message') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ id_receptor: currentChatTargetId, contenido: contenido })
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    console.error('Error al enviar mensaje:', errorData.message || response.statusText);
                    alert('Error al enviar mensaje: ' + (errorData.message || 'Verifica tu conexión.'));
                    return;
                }

                const data = await response.json();
                renderSingleMessage(data.data, true);
                els.messageInput.value = '';
                els.chatMessages.scrollTop = els.chatMessages.scrollHeight;
                lastMessageTimestamp[currentChatTargetId] = new Date(data.data.fecha_envio).getTime();

                const chatItemToUpdate = els.matchesListContainer.querySelector(`[data-user-id="${currentChatTargetId}"]`);
                if (chatItemToUpdate) {
                    const lastMessageElement = chatItemToUpdate.querySelector('p');
                    if (lastMessageElement) {
                        lastMessageElement.textContent = contenido;
                    }
                }

            } catch (error) {
                console.error('Error de red al enviar mensaje:', error);
                alert('No se pudo conectar al servidor para enviar el mensaje.');
            } finally {
                els.sendMessageBtn.disabled = false;
            }
        });

        // ELIMINADO: const initEmojiPanel = () => { ... };
        // ELIMINADO: els.emojiToggleBtn.addEventListener('click', () => { ... });
        // ELIMINADO: document.addEventListener('click', (event) => { ... });


        const handleResize = () => {
            if (window.innerWidth < 768) {
                if (currentChatTargetId) {
                    els.chatList.classList.add('hidden');
                    els.chatArea.classList.remove('hidden');
                    els.chatArea.classList.add('flex');
                } else {
                    els.chatList.classList.remove('hidden');
                    els.chatArea.classList.add('hidden');
                    els.chatArea.classList.remove('flex');
                }
            } else {
                els.chatArea.classList.remove('hidden');
                els.chatArea.classList.add('flex');
                els.chatList.classList.remove('hidden');
            }
        };

        const startPolling = () => {
            if (pollInterval) {
                clearInterval(pollInterval);
            }
            pollInterval = setInterval(async () => {
                if (currentChatTargetId) {
                    console.log('Polling para nuevos mensajes del chat...');
                    await fetchMessages(currentChatTargetId, true);
                }
            }, 3000);
        };

        const stopPolling = () => {
            if (pollInterval) {
                clearInterval(pollInterval);
                pollInterval = null;
                console.log('Polling de mensajes de chat detenido.');
            }
        };

        const startUnreadCountPolling = () => {
            if (unreadPollInterval) {
                clearInterval(unreadPollInterval);
            }
            unreadPollInterval = setInterval(async () => {
                console.log('Polling para actualizar lista de chats y contadores de no leídos...');
                await fetchActiveMatches();
            }, 5000);
        };

        const stopUnreadCountPolling = () => {
            if (unreadPollInterval) {
                clearInterval(unreadPollInterval);
                unreadPollInterval = null;
                console.log('Polling de contadores no leídos y lista de chats detenido.');
            }
        };

        // --- Inicialización ---
        fetchActiveMatches();
        // ELIMINADO: initEmojiPanel();
        handleResize();
        window.addEventListener('resize', handleResize);
        startUnreadCountPolling();
    });
</script>
@endsection