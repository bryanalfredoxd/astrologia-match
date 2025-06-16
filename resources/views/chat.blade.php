@extends('layouts.app_sesion')



@section('content')

<section class="bg-[#0A0E2A] text-white min-h-screen py-10 px-4 sm:px-6 relative overflow-hidden flex">
    <div class="flex h-full w-full overflow-hidden rounded-2xl backdrop-blur-md shadow-xl border border-[#4A0E7B] border-opacity-40">

        <!-- LADO IZQUIERDO: LISTA DE MATCHES -->
        <div id="chatList" class="w-full md:w-1/4 border-r border-white/10 bg-white bg-opacity-5 flex flex-col">
            <div class="p-4 font-bold text-xl border-b border-white/10 text-[#FFD700]">Chats</div>
            <div class="overflow-y-auto flex-1 custom-scrollbar">
                @foreach(range(1, 6) as $i)
                <div onclick="seleccionarChat({{ $i }})"
                     class="cursor-pointer flex items-center space-x-3 px-4 py-5 hover:bg-white hover:bg-opacity-10 transition">
                    <img src="https://i.pravatar.cc/40?img={{ $i }}" class="w-14 h-14 rounded-full" alt="Avatar Usuario {{ $i }}">
                    <div>
                        <h3 class="font-semibold text-lg text-white">Usuario {{ $i }}</h3>
                        <p class="text-sm text-[#A7B3EB] truncate">Último mensaje con este match...</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- LADO DERECHO: CHAT -->
        <div id="chatArea" class="hidden flex flex-col w-full md:flex-1 h-full">

            <!-- HEADER DEL CHAT -->
            <div id="chatHeader" class="bg-white bg-opacity-10 backdrop-blur-md shadow-md p-4 flex items-center justify-center border-b border-white/10">
                <p class="text-sm text-[#A7B3EB] italic">Selecciona un contacto</p>
            </div>

            <!-- MENSAJES DEL CHAT -->
            <div id="chatMessages" class="flex-1 overflow-y-auto px-4 py-6 space-y-4 custom-scrollbar">
                <p class="text-[#A7B3EB] italic text-center text-lg">Selecciona un match para comenzar a chatear</p>
            </div>

            <!-- INPUT DE MENSAJE -->
            <form onsubmit="enviarMensaje(event)" class="bg-white bg-opacity-10 backdrop-blur-md px-4 py-3 flex items-center space-x-3 border-t border-white/10">
                <button type="button" onclick="mostrarEmojis()" class="text-white text-2xl hover:text-yellow-300 transition-colors"><i class="fa-regular fa-face-smile"></i></button>
                <input id="mensajeInput" type="text" placeholder="Escribe un mensaje..." class="flex-1 px-4 py-2 rounded-full text-gray-900 focus:outline-none bg-white bg-opacity-80" disabled>
                <button type="submit" class="bg-purple-600 text-white rounded-full px-5 py-2 hover:bg-purple-700 transition" disabled><i class="fa-solid fa-paper-plane"></i></button>
            </form>

            <!-- PANEL DE EMOJIS -->
            <div id="emojiPanel" class="hidden fixed bottom-24 left-1/2 transform -translate-x-1/2 bg-white text-gray-900 p-2 rounded shadow-md text-xl z-50 border border-gray-300">
                😀 😁 😂 🤣 😊 😍 😎 🤩 😘 😢 😡 😱 🙌 🙏 💖 🎉 ❤️
            </div>
        </div>

    </div>

    <!-- Script de lógica del chat -->
    <script>
        const mensajeInput = document.getElementById('mensajeInput');
        const chatMessages = document.getElementById('chatMessages');
        const emojiPanel = document.getElementById('emojiPanel');
        const chatArea = document.getElementById('chatArea');
        const chatList = document.getElementById('chatList');
        const chatHeader = document.getElementById('chatHeader');

        function seleccionarChat(id) {
            chatArea.classList.remove('hidden');

            // Oculta lista en móvil
            if (window.innerWidth < 768) {
                chatList.classList.add('hidden');
            }

            mensajeInput.removeAttribute('disabled');
            document.querySelector('form button[type="submit"]').removeAttribute('disabled');

            chatHeader.className = 'bg-white bg-opacity-10 backdrop-blur-md shadow-md p-4 flex items-center justify-start border-b border-white/10';
            chatHeader.innerHTML = `
                <div class="flex items-center space-x-3 w-full">
                    <button onclick="volverALista()" class="text-xl md:hidden text-white hover:text-yellow-300 transition-colors"><i class="fa-solid fa-arrow-left"></i></button>
                    <img src="https://i.pravatar.cc/40?img=${id}" class="rounded-full w-10 h-10" alt="Avatar Usuario ${id}">
                    <div class="truncate">
                        <h2 class="text-lg font-semibold text-white truncate">Usuario ${id}</h2>
                        <p class="text-sm text-[#A7B3EB]">En línea</p>
                    </div>
                </div>
            `;

            chatMessages.innerHTML = `
                <div class="flex items-start space-x-2">
                    <img src="https://i.pravatar.cc/40?img=${id}" class="rounded-full w-8 h-8" alt="Avatar Usuario ${id}">
                    <div class="bg-white bg-opacity-10 rounded-2xl p-3 max-w-xs md:max-w-md">
                        <p class="text-white">¡Hola! Qué bueno verte por aquí 😊</p>
                    </div>
                </div>
            `;
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        function volverALista() {
            chatArea.classList.add('hidden');
            chatList.classList.remove('hidden');
        }

        function enviarMensaje(e) {
            e.preventDefault();
            const mensaje = mensajeInput.value.trim();
            if (mensaje !== '') {
                const msg = document.createElement('div');
                msg.className = 'flex justify-end';
                msg.innerHTML = `<div class="bg-purple-600 rounded-2xl p-3 max-w-xs md:max-w-md text-white"><p>${mensaje}</p></div>`;
                chatMessages.appendChild(msg);
                mensajeInput.value = '';
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        }

        function mostrarEmojis() {
            emojiPanel.classList.toggle('hidden');
        }

        emojiPanel.addEventListener('click', (e) => {
            if (e.target.textContent && e.target.textContent.trim() !== '') { // Asegura que no se agreguen espacios en blanco
                mensajeInput.value += e.target.textContent.trim();
                mensajeInput.focus();
                emojiPanel.classList.add('hidden');
            }
        });

        // Asegura que el scroll esté al final al cargar
        window.onload = () => {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        };
    </script>

    <!-- Estilos de scrollbar personalizados (mantenerlos aquí o en app.blade.php) -->
    <style>
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