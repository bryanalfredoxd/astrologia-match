{{-- resources/views/matched_profile.blade.php --}}
@extends('layouts.app_sesion')

@section('content')
<section class="bg-[#0A0E2A] text-white min-h-screen p-4 sm:p-6 relative overflow-hidden flex items-center justify-center">
    <div class="max-w-md mx-auto relative z-10 text-center">
        <div class="bg-gradient-to-r from-[#4A0E7B] to-[#1A1F4D] rounded-2xl shadow-xl border border-[#FFD700]/30 p-8 sm:p-10 flex flex-col items-center">
            <h2 class="text-3xl sm:text-4xl font-bold text-[#FFD700] mb-6">
                ¡Has conectado con {{ $user->nombre_completo }}!
            </h2>
            <img src="{{ $user->foto_perfil_url ? asset($user->foto_perfil_url) : 'https://placehold.co/200x200/4A0E7B/FFFFFF?text=' . strtoupper(substr($user->nombre_completo, 0, 1)) }}"
                 alt="{{ $user->nombre_completo }}"
                 class="w-48 h-48 rounded-full object-cover mb-8 border-4 border-[#FFD700] shadow-lg">

            <p class="text-lg sm:text-xl text-white mb-8">¡Felicidades por tu nuevo match!</p>

            <a href="{{ route('matchs') }}"
               class="inline-flex items-center px-6 py-3 bg-[#FFD700] hover:bg-[#F8C800] text-[#0A0E2A] font-extrabold rounded-full transition duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                <i class="fas fa-undo mr-2"></i> Volver a los Matches
            </a>
            {{-- Puedes añadir un botón para ir al chat aquí en el futuro --}}
            {{-- <a href="#" class="inline-flex items-center px-6 py-3 mt-4 bg-blue-600 hover:bg-blue-700 text-white font-extrabold rounded-full transition duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                <i class="fas fa-comments mr-2"></i> Ir al Chat
            </a> --}}
        </div>
    </div>

    <!-- Elementos decorativos de fondo -->
    <div class="absolute top-0 left-0 w-48 h-48 bg-[#4A0E7B] rounded-full mix-blend-screen opacity-10 blur-3xl animate-blob -z-10"></div>
    <div class="absolute bottom-0 right-0 w-48 h-48 bg-[#8A2BE2] rounded-full mix-blend-screen opacity-10 blur-3xl animate-blob animation-delay-2000 -z-10"></div>
    <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-[#FFD700] rounded-full mix-blend-screen opacity-5 blur-3xl animate-blob animation-delay-4000 -z-10"></div>
</section>

@include('partials.desktop-nav')
@include('partials.mobile-nav')
@endsection
