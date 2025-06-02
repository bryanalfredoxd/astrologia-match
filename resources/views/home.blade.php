@extends('layouts.app')

@section('content')

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

    @include('others.signos_zodiacales')

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

@endsection