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
    
    <!-- Preconexiones para CDNs -->
    <link rel="preconnect" href="https://cdn.tailwindcss.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Carga Lottie desde CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.4/lottie.min.js"></script>

    <!-- Manifest para PWA -->
    <link rel="manifest" href="{{ secure_url('manifest.json') }}" crossorigin="use-credentials">

    
    <style>

        * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

        /* Añadir estos estilos para prevenir layout shifts y flashes */
        html, body {
        width: 100%;
        height: 100%;
            overflow-x: hidden;
            overscroll-behavior-y: contain;
            -webkit-overflow-scrolling: touch;
        }
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
        
        @include('layouts.home.header')

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
    // Mover las funciones de utilidad al principio
    function isMobileDevice() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }

    function isPwaInstalled() {
        return window.matchMedia('(display-mode: standalone)').matches || 
               window.navigator.standalone ||
               document.referrer.includes('android-app://');
    }

    function hideInstallBanner() {
        const pwaInstallBanner = document.getElementById('pwa-install-banner');
        pwaInstallBanner.classList.add('hidden');
        pwaInstallBanner.classList.remove('animate-slide-up');
    }

    function showInstallBanner() {
        if (localStorage.getItem('pwaBannerShown') === 'true') return;
        
        const pwaInstallBanner = document.getElementById('pwa-install-banner');
        pwaInstallBanner.classList.remove('hidden');
        pwaInstallBanner.classList.add('animate-slide-up');
        
        setTimeout(hideInstallBanner, 30000);
    }

    // Cargar el Service Worker de forma no bloqueante
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            setTimeout(() => {
                navigator.serviceWorker.register('/sw.js').catch(console.error);
            }, 0);
        });
    }

    // Optimización del splash screen
    document.addEventListener('DOMContentLoaded', function() {
        const MAX_DURATION = 5000;
        const ANIMATION_SPEED = 2;
        const FADE_DURATION = 500;
        
        let animationCompleted = false;
        const startTime = Date.now();
        const splash = document.getElementById('app-splash');
        const app = document.getElementById('app');
        
        // Prevenir repaints innecesarios
        splash.style.willChange = 'opacity';
        app.style.willChange = 'opacity';
        
        function hideSplash() {
            splash.classList.add('splash-fade-out');
            app.style.display = 'block';
            
            // Forzar sincronización de layouts
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    app.classList.add('app-fade-in');
                    
                    setTimeout(() => {
                        splash.style.display = 'none';
                        splash.style.willChange = 'auto';
                        app.style.willChange = 'auto';
                        
                        if (window.animation) {
                            window.animation.stop();
                            window.animation.destroy();
                            window.animation = null;
                        }
                    }, FADE_DURATION);
                });
            });
        }
        
        function hideSplashIfReady() {
            if (animationCompleted || (Date.now() - startTime) >= MAX_DURATION) {
                hideSplash();
            }
        }
        
        try {
            window.animation = lottie.loadAnimation({
                container: document.getElementById('lottie-animation'),
                renderer: 'svg',
                loop: false,
                autoplay: true,
                path: '/js/animacion.json'
            });
            
            window.animation.setSpeed(ANIMATION_SPEED);
            window.animation.addEventListener('complete', () => {
                animationCompleted = true;
                hideSplashIfReady();
            });
            
            window.animation.addEventListener('data_failed', () => {
                console.error('Error al cargar la animación');
                hideSplash();
            });
            
            setTimeout(hideSplashIfReady, MAX_DURATION);
        } catch (e) {
            console.error('Error al inicializar animación:', e);
            hideSplash();
        }
    });

    // Optimización del banner PWA
    let deferredPrompt;
    const pwaInstallButton = document.getElementById('pwa-install-button');
    const pwaInstallCancel = document.getElementById('pwa-install-cancel');
    
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        
        // Usar requestIdleCallback para tareas no críticas
        if (typeof requestIdleCallback === 'function') {
            requestIdleCallback(() => {
                if (isMobileDevice() && !isPwaInstalled()) {
                    showInstallBanner();
                }
            });
        } else {
            setTimeout(() => {
                if (isMobileDevice() && !isPwaInstalled()) {
                    showInstallBanner();
                }
            }, 1000);
        }
    });

    if (pwaInstallButton) {
        pwaInstallButton.addEventListener('click', () => {
            hideInstallBanner();
            
            if (deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        localStorage.setItem('pwaBannerShown', 'true');
                    }
                    deferredPrompt = null;
                });
            }
        });
    }

    if (pwaInstallCancel) {
        pwaInstallCancel.addEventListener('click', () => {
            hideInstallBanner();
            localStorage.setItem('pwaBannerShown', 'true');
            setTimeout(() => {
                localStorage.removeItem('pwaBannerShown');
            }, 7 * 24 * 60 * 60 * 1000);
        });
    }

    // Verificar PWA instalada después de que todo cargue
    window.addEventListener('load', () => {
        setTimeout(() => {
            if (isPwaInstalled()) {
                console.log('La PWA se está ejecutando en modo standalone');
            }
        }, 1000);
    });
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

    @include('layouts.home.footer')

</body>
</html>