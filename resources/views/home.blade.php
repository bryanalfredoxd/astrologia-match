<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="Sistema web de emparejamiento astrológico que facilita la compatibilidad entre usuarios a través de los signos zodiacales y su proximidad geográfica">
    <meta name="theme-color" content="#1e3a8a">
    <title>AstroMatch - Encuentra tu compatibilidad astrológica</title>
    
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
            background: #ffffff; /* Color de fondo */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
             opacity: 1;
        transition: opacity 0.5s ease-out; /* Transición de 0.5 segundos */
        }
        
        #lottie-animation {
            width: 80%;
            max-width: 300px;
            height: auto;
        }

        /* Oculto inicialmente */
    #app {
        opacity: 0;
        transition: opacity 0.5s ease-in; /* Transición para la app */
    }
    
    /* Clase para el fade out */
    .splash-fade-out {
        opacity: 0 !important;
    }
    
    /* Clase para mostrar la app */
    .app-fade-in {
        opacity: 1 !important;
    }
    </style>

    <!-- Splash Screen -->
    <div id="app-splash">
        <div id="lottie-animation"></div>
    </div>

    <!-- Contenedor principal de la app (oculto inicialmente) -->
    <div id="app" style="display: none;">
        @yield('content')
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
</script>

    <style>
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
    <!-- Barra de navegación optimizada para móviles -->
    <nav class="bg-astral text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <i class="fas fa-star text-yellow-300 text-xl md:text-2xl"></i>
                <span class="text-lg md:text-xl font-bold">AstroMatch</span>
            </div>
            <div class="flex space-x-2">
                <a href="#" class="px-3 py-1 md:px-4 md:py-2 text-sm md:text-base rounded-full bg-white text-blue-800 font-semibold hover:bg-blue-100">
                    Ingresar
                </a>
                <a href="#" class="px-3 py-1 md:px-4 md:py-2 text-sm md:text-base rounded-full bg-yellow-400 text-blue-900 font-semibold hover:bg-yellow-300">
                    Registro
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section optimizada para móviles -->
    <section class="bg-astral text-white hero-content">
        <div class="container mx-auto px-4 py-8 md:py-16 flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-6 md:mb-0">
                <h1 class="hero-title text-3xl md:text-5xl font-bold mb-4">Encuentra tu conexión cósmica</h1>
                <p class="hero-subtitle text-lg md:text-xl mb-6">Descubre relaciones basadas en astrología y proximidad.</p>
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
                    <a href="#" class="px-4 py-2 md:px-6 md:py-3 bg-yellow-400 text-blue-900 font-bold rounded-full hover:bg-yellow-300 text-center text-sm md:text-base flex items-center justify-center">
                        <i class="fas fa-rocket mr-2"></i> Comenzar ahora
                    </a>
                    <a href="#" class="px-4 py-2 md:px-6 md:py-3 bg-white bg-opacity-20 text-white font-bold rounded-full hover:bg-opacity-30 text-center text-sm md:text-base flex items-center justify-center">
                        <i class="fas fa-play-circle mr-2"></i> Ver video
                    </a>
                </div>
            </div>
            <div class="md:w-1/2 flex justify-center mt-6 md:mt-0">
                <div class="relative w-48 h-48 md:w-64 md:h-64">
                    <img src="/images/lirio XD.jpg" alt="App preview" class="rounded-full border-4 border-yellow-300 w-full h-full object-cover">
                    <div class="absolute -bottom-2 -right-2 md:-bottom-4 md:-right-4 bg-white p-2 md:p-3 rounded-full shadow-lg">
                        <i class="fas fa-heart text-red-500 text-xl md:text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Cómo funciona - Optimizado para móviles -->
    <section class="py-8 md:py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-8 md:mb-12 text-gray-800">
                <i class="fas fa-cogs text-blue-500 mr-2"></i> ¿Cómo funciona?
            </h2>
            
            <div class="flex flex-col md:grid md:grid-cols-3 gap-4 md:gap-8">
                <!-- Paso 1 -->
                <div class="step-card bg-gray-50 p-4 md:p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                    <div class="bg-blue-100 w-12 h-12 md:w-16 md:h-16 rounded-full flex items-center justify-center mb-3 md:mb-4 mx-auto">
                        <i class="fas fa-user-edit text-blue-500 text-xl md:text-2xl"></i>
                    </div>
                    <h3 class="text-lg md:text-xl font-semibold text-center mb-2 md:mb-3 text-gray-800">Regístrate</h3>
                    <p class="text-sm md:text-base text-gray-600 text-center">Proporciona tus datos básicos y astrológicos.</p>
                    <div class="mt-4 text-center">
                        <a href="#" class="text-blue-500 hover:text-blue-700 text-sm flex items-center justify-center">
                            <i class="fas fa-arrow-right mr-1"></i> Más info
                        </a>
                    </div>
                </div>
                
                <!-- Paso 2 -->
                <div class="step-card bg-gray-50 p-4 md:p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                    <div class="bg-purple-100 w-12 h-12 md:w-16 md:h-16 rounded-full flex items-center justify-center mb-3 md:mb-4 mx-auto">
                        <i class="fas fa-chart-pie text-purple-500 text-xl md:text-2xl"></i>
                    </div>
                    <h3 class="text-lg md:text-xl font-semibold text-center mb-2 md:mb-3 text-gray-800">Carta Astral</h3>
                    <p class="text-sm md:text-base text-gray-600 text-center">Calculamos tu signo solar, lunar y ascendente.</p>
                    <div class="mt-4 text-center">
                        <a href="#" class="text-purple-500 hover:text-purple-700 text-sm flex items-center justify-center">
                            <i class="fas fa-arrow-right mr-1"></i> Más info
                        </a>
                    </div>
                </div>
                
                <!-- Paso 3 -->
                <div class="step-card bg-gray-50 p-4 md:p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                    <div class="bg-yellow-100 w-12 h-12 md:w-16 md:h-16 rounded-full flex items-center justify-center mb-3 md:mb-4 mx-auto">
                        <i class="fas fa-heart text-yellow-500 text-xl md:text-2xl"></i>
                    </div>
                    <h3 class="text-lg md:text-xl font-semibold text-center mb-2 md:mb-3 text-gray-800">Encuentra</h3>
                    <p class="text-sm md:text-base text-gray-600 text-center">Conoce personas compatibles cerca de ti.</p>
                    <div class="mt-4 text-center">
                        <a href="#" class="text-yellow-500 hover:text-yellow-700 text-sm flex items-center justify-center">
                            <i class="fas fa-arrow-right mr-1"></i> Más info
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- Signos Zodiacales - Completa y optimizada para móviles -->
<section class="py-8 md:py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <h2 class="text-2xl md:text-3xl font-bold text-center mb-8 md:mb-12 text-gray-800">
            <i class="fas fa-star-and-crescent text-indigo-500 mr-2"></i> Compatibilidad Astrológica
        </h2>
        <p class="text-base md:text-xl text-center max-w-3xl mx-auto mb-8 md:mb-12 text-gray-600">
            Analizamos tu signo solar, lunar y ascendente para conexiones armónicas según los elementos y modalidades.
        </p>
        
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4 md:gap-6">
            <!-- Aries -->
            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <img src="/images/zodiaco/aries.png" alt="Aries" class="w-full h-full object-contain">
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-1">Aries</h3>
                <p class="text-sm text-red-500 font-medium mb-1">Fuego - Cardinal</p>
                <p class="text-xs text-gray-500">Mar 21 - Abr 19</p>
                <div class="mt-3">
                    <i class="fas fa-fire text-red-500 text-2xl md:text-3xl"></i>
                </div>
            </div>
            
            <!-- Tauro -->
            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <img src="/images/zodiaco/taurus.png" alt="Tauro" class="w-full h-full object-contain">
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-1">Tauro</h3>
                <p class="text-sm text-green-500 font-medium mb-1">Tierra - Fijo</p>
                <p class="text-xs text-gray-500">Abr 20 - May 20</p>
                <div class="mt-3">
                    <i class="fas fa-leaf text-emerald-500 text-2xl md:text-3xl"></i>
                </div>
            </div>
            
            <!-- Géminis -->
            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <img src="/images/zodiaco/gemini.png" alt="Géminis" class="w-full h-full object-contain">
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-1">Géminis</h3>
                <p class="text-sm text-blue-500 font-medium mb-1">Aire - Mutable</p>
                <p class="text-xs text-gray-500">May 21 - Jun 20</p>
                <div class="mt-3">
                    <i class="fas fa-wind text-blue-500 text-2xl md:text-3xl"></i>
                </div>
            </div>
            
            <!-- Cáncer -->
            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <img src="/images/zodiaco/cancer.png" alt="Cáncer" class="w-full h-full object-contain">
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-1">Cáncer</h3>
                <p class="text-sm text-indigo-500 font-medium mb-1">Agua - Cardinal</p>
                <p class="text-xs text-gray-500">Jun 21 - Jul 22</p>
                <div class="mt-3">
                    <i class="fas fa-water text-indigo-500 text-2xl md:text-3xl"></i>
                </div>
            </div>
            
            <!-- Leo -->
            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <img src="/images/zodiaco/leo.png" alt="Leo" class="w-full h-full object-contain">
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-1">Leo</h3>
                <p class="text-sm text-yellow-500 font-medium mb-1">Fuego - Fijo</p>
                <p class="text-xs text-gray-500">Jul 23 - Ago 22</p>
                <div class="mt-3">
                    <i class="fas fa-fire text-red-500 text-2xl md:text-3xl"></i>
                </div>
            </div>
            
            <!-- Virgo -->
            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <img src="/images/zodiaco/virgo.png" alt="Virgo" class="w-full h-full object-contain">
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-1">Virgo</h3>
                <p class="text-sm text-emerald-500 font-medium mb-1">Tierra - Mutable</p>
                <p class="text-xs text-gray-500">Ago 23 - Sep 22</p>
                <div class="mt-3">
                    <i class="fas fa-leaf text-emerald-500 text-2xl md:text-3xl"></i>
                </div>
            </div>
            
            <!-- Libra -->
            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <img src="/images/zodiaco/libra.png" alt="Libra" class="w-full h-full object-contain">
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-1">Libra</h3>
                <p class="text-sm text-blue-500 font-medium mb-1">Aire - Cardinal</p>
                <p class="text-xs text-gray-500">Sep 23 - Oct 22</p>
                <div class="mt-3">
                    <i class="fas fa-wind text-blue-500 text-2xl md:text-3xl"></i>
                </div>
            </div>
            
            <!-- Escorpio -->
            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <img src="/images/zodiaco/scorpio.png" alt="Scorpio" class="w-full h-full object-contain">
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-1">Escorpio</h3>
                <p class="text-sm text-indigo-500 font-medium mb-1">Agua - Fijo</p>
                <p class="text-xs text-gray-500">Oct 23 - Nov 21</p>
                <div class="mt-3">
                    <i class="fas fa-water text-indigo-500 text-2xl md:text-3xl"></i>
                </div>
            </div>
            
            <!-- Sagitario -->
            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <img src="/images/zodiaco/sagittarius.png" alt="Sagittarius" class="w-full h-full object-contain">
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-1">Sagitario</h3>
                <p class="text-sm text-red-500 font-medium mb-1">Fuego - Mutable</p>
                <p class="text-xs text-gray-500">Nov 22 - Dic 21</p>
                <div class="mt-3">
                    <i class="fas fa-fire text-red-500 text-2xl md:text-3xl"></i>
                </div>
            </div>
            
            <!-- Capricornio -->
            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <img src="/images/zodiaco/capricorn.png" alt="Capricorn" class="w-full h-full object-contain">
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-1">Capricornio</h3>
                <p class="text-sm text-green-500 font-medium mb-1">Tierra - Cardinal</p>
                <p class="text-xs text-gray-500">Dic 22 - Ene 19</p>
                <div class="mt-3">
                    <i class="fas fa-leaf text-emerald-500 text-2xl md:text-3xl"></i>
                </div>
            </div>
            
            <!-- Acuario -->
            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <img src="/images/zodiaco/aquarius.png" alt="Aquarius" class="w-full h-full object-contain">
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-1">Acuario</h3>
                <p class="text-sm text-blue-500 font-medium mb-1">Aire - Fijo</p>
                <p class="text-xs text-gray-500">Ene 20 - Feb 18</p>
                <div class="mt-3">
                    <i class="fas fa-wind text-blue-500 text-2xl md:text-3xl"></i>
                </div>
            </div>
            
            <!-- Piscis -->
            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3">
                    <img src="/images/zodiaco/pisces.png" alt="Pisces" class="w-full h-full object-contain">
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-gray-800 mb-1">Piscis</h3>
                <p class="text-sm text-indigo-500 font-medium mb-1">Agua - Mutable</p>
                <p class="text-xs text-gray-500">Feb 19 - Mar 20</p>
                <div class="mt-3">
                    <i class="fas fa-water text-indigo-500 text-2xl md:text-3xl"></i>
                </div>
            </div>
        </div>
        
        <!-- Información adicional sobre compatibilidad -->
        <div class="mt-12 bg-white rounded-xl shadow-md p-6 max-w-4xl mx-auto">
            <h3 class="text-xl font-bold text-center mb-4 text-gray-800">
                <i class="fas fa-handshake text-purple-500 mr-2"></i> ¿Cómo determinamos la compatibilidad?
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-purple-50 p-4 rounded-lg">
                    <div class="flex items-center mb-2">
                        <div class="bg-purple-100 w-10 h-10 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-sun text-purple-500"></i>
                        </div>
                        <h4 class="font-semibold text-gray-800">Signo Solar</h4>
                    </div>
                    <p class="text-sm text-gray-600">Tu personalidad básica y esencia según tu fecha de nacimiento.</p>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="flex items-center mb-2">
                        <div class="bg-blue-100 w-10 h-10 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-moon text-blue-500"></i>
                        </div>
                        <h4 class="font-semibold text-gray-800">Signo Lunar</h4>
                    </div>
                    <p class="text-sm text-gray-600">Tus emociones, instintos y necesidades emocionales más profundas.</p>
                </div>
                <div class="bg-indigo-50 p-4 rounded-lg">
                    <div class="flex items-center mb-2">
                        <div class="bg-indigo-100 w-10 h-10 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-arrow-up text-indigo-500"></i>
                        </div>
                        <h4 class="font-semibold text-gray-800">Ascendente</h4>
                    </div>
                    <p class="text-sm text-gray-600">Cómo te presentas al mundo y la primera impresión que das.</p>
                </div>
            </div>
            
            <div class="mt-6 text-center">
                <a href="#" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-full hover:bg-purple-700 text-sm font-medium">
                    <i class="fas fa-chart-bar mr-2"></i> Ver mi compatibilidad detallada
                </a>
            </div>
        </div>
    </div>
</section>

    <!-- CTA optimizado para móviles -->
    <section class="py-8 md:py-16 bg-astral text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-2xl md:text-3xl font-bold mb-4 md:mb-6">¿Listo para tu conexión cósmica?</h2>
            <p class="text-base md:text-xl mb-6 md:mb-8 max-w-2xl mx-auto">
                <i class="fas fa-map-marker-alt mr-2"></i> Encuentra personas compatibles según los astros cerca de ti.
            </p>
            <a href="#" class="cta-button inline-block px-6 py-3 md:px-8 md:py-4 bg-yellow-400 text-blue-900 font-bold rounded-full hover:bg-yellow-300 text-sm md:text-lg flex items-center justify-center mx-auto w-max">
                <i class="fas fa-rocket mr-2"></i> Comenzar ahora
            </a>
        </div>
    </section>

<!-- Footer optimizado para móviles -->
<footer class="bg-gray-900 text-white py-4 md:py-8">
    <div class="container mx-auto px-3 md:px-4">
        <div class="flex flex-col md:grid md:grid-cols-3 gap-4 md:gap-6">
            <!-- Logo y descripción -->
            <div class="text-center md:text-left mb-2 md:mb-0">
                <div class="flex items-center justify-center md:justify-start space-x-1 md:space-x-2 mb-2 md:mb-3">
                    <i class="fas fa-star text-yellow-300 text-lg md:text-xl"></i>
                    <span class="text-base md:text-lg font-bold">AstroMatch</span>
                </div>
                <p class="text-[0.65rem] md:text-xs text-gray-400">
                    <i class="fas fa-globe-americas mr-1"></i> Emparejamiento astrológico por proximidad geográfica.
                </p>
            </div>
            
            <!-- Legal -->
            <div class="text-center md:text-left mb-2 md:mb-0">
                <h3 class="text-sm md:text-base font-semibold mb-1 md:mb-2">
                    <i class="fas fa-balance-scale mr-1 md:mr-2"></i> Legal
                </h3>
                <ul class="space-y-0.5 md:space-y-1">
                    <li><a href="#" class="text-[0.65rem] md:text-xs text-gray-400 hover:text-white flex items-center justify-center md:justify-start">
                        <i class="fas fa-file-contract mr-1"></i> Términos
                    </a></li>
                    <li><a href="#" class="text-[0.65rem] md:text-xs text-gray-400 hover:text-white flex items-center justify-center md:justify-start">
                        <i class="fas fa-lock mr-1"></i> Privacidad
                    </a></li>
                </ul>
            </div>
            
            <!-- Contacto -->
            <div class="text-center md:text-left">
                <h3 class="text-sm md:text-base font-semibold mb-1 md:mb-2">
                    <i class="fas fa-envelope mr-1 md:mr-2"></i> Contacto
                </h3>
                <ul class="space-y-0.5 md:space-y-1">
                    <li class="flex items-start justify-center md:justify-start">
                        <i class="fas fa-at mt-[0.15rem] mr-1 text-gray-400 text-[0.6rem] md:text-xs"></i>
                        <span class="text-[0.65rem] md:text-xs text-gray-400">contacto@astromatch.com</span>
                    </li>
                    <li class="flex items-start justify-center md:justify-start">
                        <i class="fab fa-whatsapp mt-[0.15rem] mr-1 text-gray-400 text-[0.6rem] md:text-xs"></i>
                        <span class="text-[0.65rem] md:text-xs text-gray-400">+58 123 456 7890</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-4 md:mt-6 pt-4 md:pt-6 text-center text-gray-400">
            <p class="text-[0.6rem] md:text-xs">
                <i class="far fa-copyright mr-1"></i> 2025 AstroMatch. Todos los derechos reservados.
            </p>
            <p class="mt-0.5 text-[0.55rem]">
                <i class="fas fa-graduation-cap mr-1"></i> Trabajo Especial de Grado - UNELLEZ
            </p>
        </div>
    </div>
</footer>
<!-- Banner de instalación PWA (oculto inicialmente) -->
<div id="pwa-install-banner" class="fixed bottom-0 left-0 right-0 bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg z-50 hidden">
    <div class="container mx-auto p-4">
        <!-- Contenido principal centrado -->
        <div class="flex flex-col items-center text-center">
            <!-- Icono e icono -->
            <div class="flex items-center mb-3">
                <i class="fas fa-mobile-alt text-3xl mr-3 text-yellow-300"></i>
                <div>
                    <h3 class="font-bold text-lg">Instalar AstroMatch</h3>
                    <p class="text-sm opacity-90">Disfruta de la mejor experiencia con nuestra app</p>
                </div>
            </div>
            
            <!-- Botones centrados y simétricos -->
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

<!-- Script para PWA mejorado -->
<script>
    // Variables globales
    let deferredPrompt;
    const pwaInstallBanner = document.getElementById('pwa-install-banner');
    const pwaInstallButton = document.getElementById('pwa-install-button');
    const pwaInstallCancel = document.getElementById('pwa-install-cancel');
    
    // Verificar si el navegador soporta Service Worker
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            // Registrar el Service Worker
            navigator.serviceWorker.register('/sw.js')
                .then(function(registration) {
                    console.log('ServiceWorker registrado con éxito: ', registration.scope);
                })
                .catch(function(err) {
                    console.log('Error al registrar ServiceWorker: ', err);
                });
        });
    }

    // Manejar el evento antes de instalar la PWA
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        console.log('Evento beforeinstallprompt activado');
        
        // Guardar el evento para usarlo más tarde
        deferredPrompt = e;
        
        // Mostrar el banner solo en móviles y si la PWA no está instalada
        if (isMobileDevice() && !isPwaInstalled()) {
            showInstallBanner();
        }
    });

    // Manejar clic en el botón de instalación
    pwaInstallButton.addEventListener('click', (e) => {
        // Ocultar el banner
        hideInstallBanner();
        
        // Mostrar el prompt de instalación
        if (deferredPrompt) {
            deferredPrompt.prompt();
            
            // Esperar a que el usuario responda al prompt
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('Usuario aceptó la instalación');
                    // Guardar en localStorage que el usuario ya vio el banner
                    localStorage.setItem('pwaBannerShown', 'true');
                } else {
                    console.log('Usuario rechazó la instalación');
                }
                deferredPrompt = null;
            });
        }
    });

    // Manejar clic en el botón de cancelar
    pwaInstallCancel.addEventListener('click', (e) => {
        hideInstallBanner();
        // Guardar en localStorage para no mostrar el banner por un tiempo
        localStorage.setItem('pwaBannerShown', 'true');
        setTimeout(() => {
            localStorage.removeItem('pwaBannerShown');
        }, 7 * 24 * 60 * 60 * 1000); // No mostrar por 7 días
    });

    // Mostrar el banner de instalación
    function showInstallBanner() {
        // Verificar si ya se mostró el banner recientemente
        if (localStorage.getItem('pwaBannerShown') === 'true') {
            return;
        }
        
        pwaInstallBanner.classList.remove('hidden');
        pwaInstallBanner.classList.add('animate-slide-up');
        
        // Ocultar automáticamente después de 30 segundos
        setTimeout(hideInstallBanner, 30000);
    }

    // Ocultar el banner de instalación
    function hideInstallBanner() {
        pwaInstallBanner.classList.add('hidden');
        pwaInstallBanner.classList.remove('animate-slide-up');
    }

    // Detectar si es un dispositivo móvil
    function isMobileDevice() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }

    // Verificar si la PWA ya está instalada
    function isPwaInstalled() {
        return window.matchMedia('(display-mode: standalone)').matches || 
               window.navigator.standalone ||
               document.referrer.includes('android-app://');
    }

    // Detectar si la PWA se está ejecutando en modo standalone
    if (isPwaInstalled()) {
        console.log('La PWA se está ejecutando en modo standalone');
        // Puedes agregar comportamientos específicos para cuando la app está instalada
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
</body>
</html>