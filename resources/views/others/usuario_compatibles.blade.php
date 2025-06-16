@extends('layouts.app_sesion')

@section('content')
<section class="bg-[#0A0E2A] text-white min-h-screen py-10 px-4 sm:px-6 flex items-center justify-center relative overflow-hidden">

    <div class="max-w-7xl mx-auto text-center relative z-10">
        {{-- Contenedor principal de los resultados, adaptado al estilo de carta_astral.blade.php --}}
        <div class="bg-white bg-opacity-10 p-10 rounded-2xl backdrop-blur-md shadow-xl max-w-lg mx-auto text-center border border-[#4A0E7B] border-opacity-40">
            <h1 class="text-3xl font-bold mb-4 text-[#FFD700]">¡Tu energía ya está conectando!</h1>
            <p class="text-lg mb-6 text-[#A7B3EB]">Hay <span id="contador" class="font-bold text-yellow-300 text-2xl">0</span> personas compatibles contigo basadas en tu perfil.</p>

            <a href="{{ route('register') }}" class="inline-block bg-white text-purple-800 font-semibold px-6 py-3 rounded-full shadow-lg hover:bg-purple-100 transition-all duration-200">
                <i class="fa-solid fa-user-plus mr-2"></i>Conócelas registrándote ahora
            </a>
        </div>
    </div>

    <!-- Script de contador animado -->
    <script>
        // Contador animado
        // Asegúrate de que $totalCompatibles se esté pasando a esta vista desde el controlador de Laravel
        let total = {{ $totalCompatibles ?? 0 }}; // Usa 0 como valor predeterminado si no se pasa
        let contador = document.getElementById('contador');
        let i = 0;
        let intervalo = setInterval(() => {
            if (i < total) {
                i++;
                contador.innerText = i;
            } else {
                clearInterval(intervalo);
            }
        }, 50);
    </script>

    <!-- Elementos decorativos de fondo (copia de carta_astral.blade.php para consistencia) -->
    <div class="absolute top-0 left-0 w-48 h-48 bg-[#4A0E7B] rounded-full mix-blend-screen opacity-10 blur-3xl animate-blob -z-10"></div>
    <div class="absolute bottom-0 right-0 w-48 h-48 bg-[#8A2BE2] rounded-full mix-blend-screen opacity-10 blur-3xl animate-blob animation-delay-2000 -z-10"></div>
    <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-[#FFD700] rounded-full mix-blend-screen opacity-5 blur-3xl animate-blob animation-delay-4000 -z-10"></div>
</section>
@endsection