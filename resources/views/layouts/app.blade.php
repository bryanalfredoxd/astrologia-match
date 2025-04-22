<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstroMatch - @yield('title', 'Encuentra tu conexión cósmica')</title>
    <link rel="manifest" href="{{ secure_url('manifest.json') }}" crossorigin="use-credentials">
    <link rel="preload" href="/images/fondo1-mobile.webp" as="image" media="(max-width: 768px)">
    <link rel="preload" href="/images/fondo1.webp" as="image" media="(min-width: 769px)">
    <link rel="preload" href="/css/app.css" as="style">
    <link rel="preload" href="/js/app.js" as="script">
    {{-- Aquí activamos la PWA --}}
    @laravelPWA

    <!-- Splash Screen CSS -->
    <style>
        .splash-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1A1A40, #3A0CA3);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            transition: opacity 0.5s ease;
        }
        
        .splash-logo {
            width: 150px;
            height: 150px;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }
        
        .splash-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #F5C518;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
        
        .splash-hidden {
            opacity: 0;
            pointer-events: none;
        }
    </style>

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="{{ secure_url('css/app.css') }}" rel="stylesheet">
    <script src="{{ secure_url('js/app.js') }}"></script>

    @stack('styles') 
</head>
<body>
    <!-- Splash Screen -->
    @if(request()->is('/'))
    <div id="splash" class="splash-screen">
        <img src="/images/splash/icon-512x512.webp" alt="AstroMatch Logo" class="splash-logo">
        <div class="splash-spinner"></div>
    </div>
    @endif

    @include('layouts.header')

    <main style="margin-top: 80px;"> {{-- Espacio para el navbar fijo --}}
        @yield('content')
    </main>

    @include('layouts.footer')

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Script para ocultar el splash -->
    <script>
        
            document.addEventListener('DOMContentLoaded', () => {
                const splash = document.getElementById('splash');
                const app = document.getElementById('app');
                
                // Función para ocultar el splash
                function hideSplash() {
                    splash.classList.add('splash-hidden');
                    app.classList.add('app-loaded');
                    
                    splash.addEventListener('transitionend', () => {
                        splash.remove();
                    });
                }
                
                // Ocultar después de 3 segundos como máximo
                const maxWait = setTimeout(hideSplash, 3000);
                
                // Intentar ocultar cuando todo esté listo
                if (document.readyState === 'complete') {
                    hideSplash();
                } else {
                    window.addEventListener('load', hideSplash);
                    document.addEventListener('readystatechange', () => {
                        if (document.readyState === 'complete') {
                            hideSplash();
                        }
                    });
                }
                
                // Cancelar el timeout si ya se ocultó
                window.addEventListener('app-loaded', () => {
                    clearTimeout(maxWait);
                });
            });
    </script>

    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
        
    </script>
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/serviceworker.js', { scope: '/' })
                    .then(registration => {
                        console.log('SW registered:', registration);
                        registration.update();
                    });
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
