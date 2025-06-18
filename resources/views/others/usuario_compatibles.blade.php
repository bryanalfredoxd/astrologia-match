@extends('layouts.app')

@section('content')
<section class="bg-gradient-to-br from-[#1e3a8a] via-[#3b82f6] to-[#9333ea] text-white min-h-screen py-8 px-4 sm:px-6 lg:px-8 flex items-center justify-center relative overflow-hidden">
    <!-- Elementos decorativos de fondo -->
    <div class="absolute inset-0 overflow-hidden -z-10">
        <div class="absolute top-10 left-1/4 w-1 h-1 bg-white rounded-full opacity-70"></div>
        <div class="absolute top-20 right-1/4 w-1 h-1 bg-white rounded-full opacity-70"></div>
        <div class="absolute bottom-1/3 left-1/3 w-1 h-1 bg-white rounded-full opacity-70"></div>
        <div class="absolute top-1/2 right-1/2 w-1 h-1 bg-white rounded-full opacity-70"></div>
        <div class="absolute bottom-20 left-20 w-1 h-1 bg-white rounded-full opacity-70"></div>
        <div class="absolute top-32 right-32 w-1 h-1 bg-white rounded-full opacity-70"></div>
    </div>

    <!-- Elementos decorativos animados -->
    <div class="absolute top-0 left-0 w-64 h-64 bg-[#4A0E7B] rounded-full mix-blend-screen opacity-10 blur-3xl animate-blob -z-10"></div>
    <div class="absolute bottom-0 right-0 w-64 h-64 bg-[#8A2BE2] rounded-full mix-blend-screen opacity-10 blur-3xl animate-blob animation-delay-2000 -z-10"></div>
    <div class="absolute top-1/4 left-1/4 w-40 h-40 bg-[#FFD700] rounded-full mix-blend-screen opacity-5 blur-3xl animate-blob animation-delay-4000 -z-10"></div>

    <div class="max-w-2xl w-full mx-auto relative z-10 animate-fade-in">
        <!-- Contenedor principal -->
        <div class="bg-[#0A0E2A] rounded-2xl p-8 sm:p-10 shadow-2xl border border-[#4A0E7B] text-center">
            <!-- Icono decorativo -->
            <div class="w-24 h-24 mx-auto mb-6 flex items-center justify-center bg-[#FFD700]/10 rounded-full border border-[#FFD700]/30">
                <i class="fas fa-heart text-4xl text-[#FFD700]"></i>
            </div>

            <!-- Encabezado -->
            <h1 class="text-2xl md:text-3xl font-bold text-[#FFD700] mb-4">
                <i class="fas fa-bolt mr-2"></i>¡Tu energía ya está conectando!
            </h1>

            <!-- Contador -->
            <div class="mb-8">
                <p class="text-lg md:text-xl text-[#E0E7FF]">
                    Hay <span id="contador" class="font-bold text-[#FFD700] text-3xl md:text-4xl mx-1">0</span> 
                    personas compatibles contigo
                </p>
                <p class="text-sm text-[#A7B3EB] mt-2">Basado en tu perfil astrológico y preferencias</p>
            </div>

            <!-- CTA -->
            <div class="mt-6">
                <a href="{{ route('register') }}" 
                   class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-[#FFD700] to-[#F8C800] text-[#0A0E2A] font-bold rounded-full transition-all duration-300 hover:shadow-lg hover:shadow-[#FFD700]/30">
                    <i class="fas fa-user-plus mr-2"></i> Conócelas registrándote ahora
                </a>
            </div>

            <!-- Información adicional -->
            <div class="mt-10 pt-6 border-t border-[#4A0E7B]/40">
                <p class="text-sm text-[#A7B3EB]">
                    <i class="fas fa-lock mr-1"></i> Tu privacidad está protegida. Solo verás perfiles que coincidan con tus criterios.
                </p>
            </div>
        </div>
    </div>

    <script>
        // Contador animado
        document.addEventListener('DOMContentLoaded', function() {
            let total = {{ $totalCompatibles ?? 0 }};
            let contador = document.getElementById('contador');
            let incremento = Math.max(1, Math.floor(total / 20)); // Ajusta la velocidad según el total
            let i = 0;
            
            if (total > 0) {
                let intervalo = setInterval(() => {
                    if (i < total) {
                        i = Math.min(i + incremento, total);
                        contador.innerText = i;
                        
                        // Añadir efecto cuando llega al final
                        if (i === total) {
                            contador.classList.add('animate-pulse');
                            setTimeout(() => {
                                contador.classList.remove('animate-pulse');
                            }, 1000);
                        }
                    } else {
                        clearInterval(intervalo);
                    }
                }, 50);
            } else {
                contador.innerText = total;
            }
        });
    </script>
</section>

<style>
    /* Animaciones personalizadas consistentes */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    
    .animate-fade-in {
        animation: fadeIn 0.8s ease-out forwards;
    }
    
    .animate-blob {
        animation: blob 15s infinite ease-in-out;
    }
    
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    
    .animation-delay-4000 {
        animation-delay: 4s;
    }
</style>
@endsection