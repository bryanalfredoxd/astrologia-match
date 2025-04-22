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

    <style>
        .register-section {
            background: url('/images/fondo1.webp') no-repeat center center;
            background-size: cover;
            transition: background-image 0.3s ease;
        }
    
        @media (max-width: 768px) {
            .register-section {
                background-image: url('/images/fondo1-mobile.webp');
            }
        }
    </style>

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
        content: url("/images/splash/icon-512x512.webp");
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
        <img src="/images/splash/icon-512x512.webp" alt="AstroMatch Logo" class="splash-logo" loading="eager">
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

<!-- Precarga inteligente de imágenes con detección de vista previa -->
<link rel="preload" href="/images/fondo1-mobile.webp" as="image" media="(max-width: 768px)">
<link rel="preload" href="/images/fondo1.webp" as="image" media="(min-width: 769px)">



<style>
    .register-section {
        background: url('/images/fondo1.webp') no-repeat center center;
        background-size: cover;
        transition: background-image 0.3s ease;
    }

    @media (max-width: 768px) {
        .register-section {
            background-image: url('/images/fondo1-mobile.webp');
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const section = document.getElementById('background-section');
        if (!section) return;

        // Precargar imágenes en JavaScript para mejor caché
        const imagesToLoad = [];
        const mobileImage = new Image();
        const desktopImage = new Image();

        mobileImage.src = '/images/fondo1-mobile.webp';
        desktopImage.src = '/images/fondo1.webp';

        imagesToLoad.push(mobileImage, desktopImage);

        // Verificar si las imágenes están en cache
        function checkImageCache() {
            return new Promise((resolve) => {
                let loadedCount = 0;
                
                imagesToLoad.forEach(img => {
                    if (img.complete) {
                        loadedCount++;
                    } else {
                        img.onload = () => {
                            loadedCount++;
                            if (loadedCount === imagesToLoad.length) resolve();
                        };
                    }
                });

                if (loadedCount === imagesToLoad.length) resolve();
            });
        }

        // Opcional: Usar IntersectionObserver para carga diferida
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        checkImageCache().then(() => {
                            console.log('Imágenes de fondo cargadas y listas');
                        });
                        observer.unobserve(entry.target);
                    }
                });
            }, { rootMargin: '200px' });

            observer.observe(section);
        } else {
            // Fallback para navegadores sin IntersectionObserver
            checkImageCache();
        }

        // Manejo de cambio de tamaño con debounce para mejor performance
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                // El CSS media query ya maneja el cambio, esto es solo para forzar repaint si es necesario
                section.style.backgroundImage = window.innerWidth <= 768 ? 
                    'url(/images/fondo1-mobile.webp)' : 
                    'url(/images/fondo1.webp)';
            }, 100);
        });
    });
</script>

    <!-- Script optimizado para el splash -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const splash = document.getElementById('splash');
        if (!splash) return;
        
        // Verificar si ya se mostró el splash antes (usando localStorage)
        const splashShown = localStorage.getItem('splashShown');
        
        if (splashShown) {
            // Si ya se mostró antes, eliminar inmediatamente
            splash.remove();
            return;
        }
        
        // Marcar como mostrado para futuras visitas
        localStorage.setItem('splashShown', 'true');
        
        // Precargar la imagen para asegurar carga rápida
        const img = new Image();
        img.src = "/images/splash/icon-512x512.webp";
        
        // Función para ocultar el splash
        function hideSplash() {
            splash.classList.add('splash-hidden');
            
            splash.addEventListener('transitionend', () => {
                splash.remove();
            });
        }
        
        // Ocultar después de exactamente 5 segundos
        setTimeout(hideSplash, 5000);
        
        // Opcional: Ocultar antes si la página carga completamente
        window.addEventListener('load', () => {
            // Si la página carga antes de los 5 segundos, esperar al menos 2 segundos
            const elapsed = performance.now();
            const remaining = Math.max(2000, 5000 - elapsed);
            setTimeout(hideSplash, remaining);
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
