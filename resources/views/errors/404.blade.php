@extends('layouts.app')

@section('title', 'Error cósmico')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-[#1A1F4D] to-[#4A0E7B] p-4">
    <div class="w-full max-w-md bg-[#0A0E2A] bg-opacity-90 backdrop-blur-sm rounded-2xl shadow-lg border border-[#4A0E7B] p-8 text-center">
        <!-- Contenedor de la animación Lottie -->
        <div id="error-animation" class="w-full h-64 mx-auto mb-6"></div>
        
        <div class="space-y-4">
            <h1 class="text-2xl md:text-3xl font-bold text-[#FFD700]">
                ¡Error cósmico detectado!
            </h1>
            
            <p class="text-[#A7B3EB] text-lg">
                La constelación que buscas se ha perdido en el cosmos.
            </p>
            
            <div class="pt-6 flex flex-col sm:flex-row justify-center gap-4">
                <!-- Botón para volver atrás -->
                <button onclick="window.history.back()" class="px-6 py-3 md:px-8 md:py-4 bg-gradient-to-r from-[#FFD700] to-[#F8C800] text-[#0A0E2A] font-bold rounded-full hover:shadow-lg hover:shadow-[#FFD700]/30 transition duration-300 text-sm md:text-lg flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i> Regresar a la base
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cargar animación Lottie
        if (typeof lottie !== 'undefined') {
            const errorAnimation = lottie.loadAnimation({
                container: document.getElementById('error-animation'),
                renderer: 'svg',
                loop: true,
                autoplay: true,
                path: '/js/error_cosmico.json'
            });
            
            window.addEventListener('resize', function() {
                errorAnimation.resize();
            });
        }
    });
</script>
@endsection