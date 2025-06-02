<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Sistema web de emparejamiento astrológico que facilita la compatibilidad entre usuarios a través de los signos zodiacales y su proximidad geográfica">
    <meta name="theme-color" content="#1e3a8a">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'AstroMatch - Encuentra tu compatibilidad astrológica')</title>
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Manifest para PWA -->
    <link rel="manifest" href="{{ secure_url('manifest.json') }}" crossorigin="use-credentials">

    <!-- Carga Lottie desde CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.4/lottie.min.js"></script>
    
    <style>
        #app-splash {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #9333ea 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.5s ease-out;
        }

        #lottie-animation {
            width: 300px;
            height: 300px;
            background: white;
            border-radius: 50%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Oculto inicialmente */
        #app {
            opacity: 0;
            transition: opacity 0.5s ease-in;
        }
        
        /* Clase para el fade out */
        .splash-fade-out {
            opacity: 0 !important;
        }
        
        /* Clase para mostrar la app */
        .app-fade-in {
            opacity: 1 !important;
        }
        
        .bg-astral {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #9333ea 100%);
        }
        
        .zodiac-icon {
            transition: all 0.3s ease;
        }
        
        .zodiac-icon:hover {
            transform: scale(1.1);
            filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.7));
        }
        
        /* Mejoras para móviles */
        @media (max-width: 640px) {
            .hero-content {
                padding-top: 2rem;
                padding-bottom: 2rem;
            }
            
            .hero-title {
                font-size: 2rem;
                line-height: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .step-card {
                margin-bottom: 1.5rem;
            }
            
            .zodiac-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 0.75rem;
            }
            
            .cta-button {
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
            }
        }
    </style>
    @laravelPWA
</head>
<body class="bg-gray-100 font-sans">
    <!-- Splash Screen -->
    <div id="app-splash">
        <div id="lottie-animation"></div>
    </div>

    <!-- Contenedor principal de la app (oculto inicialmente) -->
    <div id="app" style="display: none;">
        
        @include('layouts.header')

        <!-- Contenido principal -->
        <main>
            @yield('content')
        </main>

        <!-- Banner de instalación PWA (oculto inicialmente) -->
        <div id="pwa-install-banner" class="fixed bottom-0 left-0 right-0 bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg z-50 hidden">
            <div class="container mx-auto p-4">
                <div class="flex flex-col items-center text-center">
                    <div class="flex items-center mb-3">
                        <i class="fas fa-mobile-alt text-3xl mr-3 text-yellow-300"></i>
                        <div>
                            <h3 class="font-bold text-lg">Instalar AstroMatch</h3>
                            <p class="text-sm opacity-90">Disfruta de la mejor experiencia con nuestra app</p>
                        </div>
                    </div>
                    
                    <div class="flex justify-center space-x-4 w-full max-w-xs">
                        <button id="pwa-install-cancel" class="px-5 py-2 bg-white bg-opacity-10 hover:bg-opacity-20 rounded-full text-sm font-medium transition-all flex-1">
                            Más tarde
                        </button>
                        <button id="pwa-install-button" class="px-5 py-2 bg-yellow-400 hover:bg-yellow-300 text-blue-900 font-semibold rounded-full text-sm flex items-center justify-center flex-1">
                            <i class="fas fa-download mr-2"></i> Instalar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configuración
            const MAX_DURATION = 5000; // 5 segundos máximo
            const ANIMATION_SPEED = 2; // Velocidad x2
            const FADE_DURATION = 500; // 0.5 segundos para el fade
            
            // Variables de control
            let animationCompleted = false;
            let startTime = Date.now();
            
            // Carga la animación Lottie
            var animation = lottie.loadAnimation({
                container: document.getElementById('lottie-animation'),
                renderer: 'svg',
                loop: false,
                autoplay: true,
                path: '/js/animacion.json'
            });
            
            // Acelera la animación
            animation.setSpeed(ANIMATION_SPEED);
            
            // Cuando la animación termina
            animation.addEventListener('complete', function() {
                animationCompleted = true;
                hideSplashIfReady();
            });
            
            // Por si hay algún error
            animation.addEventListener('data_failed', function() {
                console.error('Error al cargar la animación');
                hideSplash();
            });
            
            // Temporizador de duración máxima
            setTimeout(hideSplashIfReady, MAX_DURATION);
            
            // Función para ocultar el splash cuando esté listo
            function hideSplashIfReady() {
                // Calcula el tiempo transcurrido
                const elapsed = Date.now() - startTime;
                
                // Si la animación ya completó o pasaron los 5 segundos
                if (animationCompleted || elapsed >= MAX_DURATION) {
                    hideSplash();
                }
            }
            
            // Función para ocultar el splash con efecto fade
            function hideSplash() {
                const splash = document.getElementById('app-splash');
                const app = document.getElementById('app');
                
                // Aplicamos la clase para el fade out
                splash.classList.add('splash-fade-out');
                
                // Mostramos la app antes del fade para que esté lista
                app.style.display = 'block';
                
                // Aplicamos fade in a la app después de un pequeño delay
                setTimeout(() => {
                    app.classList.add('app-fade-in');
                }, 50);
                
                // Eliminamos el splash del DOM después de la transición
                setTimeout(() => {
                    splash.style.display = 'none';
                    
                    // Detener la animación para liberar recursos
                    if (animation) {
                        animation.stop();
                        animation.destroy();
                    }
                }, FADE_DURATION);
            }
        });

        // Script para PWA
        let deferredPrompt;
        const pwaInstallBanner = document.getElementById('pwa-install-banner');
        const pwaInstallButton = document.getElementById('pwa-install-button');
        const pwaInstallCancel = document.getElementById('pwa-install-cancel');
        
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js')
                    .then(function(registration) {
                        console.log('ServiceWorker registrado con éxito: ', registration.scope);
                    })
                    .catch(function(err) {
                        console.log('Error al registrar ServiceWorker: ', err);
                    });
            });
        }

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            console.log('Evento beforeinstallprompt activado');
            
            deferredPrompt = e;
            
            if (isMobileDevice() && !isPwaInstalled()) {
                showInstallBanner();
            }
        });

        pwaInstallButton.addEventListener('click', (e) => {
            hideInstallBanner();
            
            if (deferredPrompt) {
                deferredPrompt.prompt();
                
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('Usuario aceptó la instalación');
                        localStorage.setItem('pwaBannerShown', 'true');
                    } else {
                        console.log('Usuario rechazó la instalación');
                    }
                    deferredPrompt = null;
                });
            }
        });

        pwaInstallCancel.addEventListener('click', (e) => {
            hideInstallBanner();
            localStorage.setItem('pwaBannerShown', 'true');
            setTimeout(() => {
                localStorage.removeItem('pwaBannerShown');
            }, 7 * 24 * 60 * 60 * 1000);
        });

        function showInstallBanner() {
            if (localStorage.getItem('pwaBannerShown') === 'true') {
                return;
            }
            
            pwaInstallBanner.classList.remove('hidden');
            pwaInstallBanner.classList.add('animate-slide-up');
            
            setTimeout(hideInstallBanner, 30000);
        }

        function hideInstallBanner() {
            pwaInstallBanner.classList.add('hidden');
            pwaInstallBanner.classList.remove('animate-slide-up');
        }

        function isMobileDevice() {
            return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        }

        function isPwaInstalled() {
            return window.matchMedia('(display-mode: standalone)').matches || 
                   window.navigator.standalone ||
                   document.referrer.includes('android-app://');
        }

        if (isPwaInstalled()) {
            console.log('La PWA se está ejecutando en modo standalone');
        }
    </script>

    <style>
        /* Animación para el banner */
        @keyframes slide-up {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }
        
        .animate-slide-up {
            animation: slide-up 0.3s ease-out forwards;
        }
        
        /* Estilos para el banner */
        #pwa-install-banner {
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.15);
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
        }
        
        @media (min-width: 768px) {
            #pwa-install-banner {
                max-width: 450px;
                left: 50%;
                transform: translateX(-50%);
                bottom: 20px;
                border-radius: 12px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            }
            
            #pwa-install-banner.animate-slide-up {
                animation: slide-up 0.3s ease-out forwards;
            }
        }
    </style>

    @include('layouts.footer')

</body>
</html>