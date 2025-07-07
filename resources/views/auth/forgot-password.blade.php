@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-[#1A1F4D] to-[#4A0E7B] p-4 sm:p-6">
    <div class="w-full max-w-md px-4 py-8 sm:px-8 sm:py-12 bg-[#0A0E2A] bg-opacity-90 backdrop-blur-sm rounded-xl sm:rounded-2xl shadow-lg">
        <div class="flex justify-center mb-6 sm:mb-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-center text-[#FFD700]">
                <i class="fas fa-key mr-2"></i> Recuperar Contraseña
            </h2>
        </div>

        @if (session('status'))
            <div class="mb-4 px-3 py-2 sm:px-4 sm:py-3 bg-green-500 bg-opacity-20 text-green-300 text-sm sm:text-base rounded-lg">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4 sm:space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-xs sm:text-sm font-medium text-[#A7B3EB]">Correo Electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                    class="mt-1 block w-full px-3 py-2 sm:px-4 sm:py-3 text-xs sm:text-sm bg-[#1A1F4D] border border-[#4A0E7B] rounded-lg text-[#A7B3EB] placeholder-[#4A0E7B] focus:outline-none focus:ring-2 focus:ring-[#FFD700] focus:border-transparent @error('email') border-red-500 @enderror">
                
                @error('email')
                    <span class="mt-1 text-xs sm:text-sm text-red-400">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-3 sm:py-3 sm:px-4 border border-transparent rounded-lg shadow-sm text-xs sm:text-sm font-medium text-[#0A0E2A] bg-[#FFD700] hover:bg-[#FFC000] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FFD700] transition duration-150 ease-in-out">
                    Enviar Enlace de Recuperación
                </button>
            </div>

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-xs sm:text-sm text-[#A7B3EB] hover:text-[#FFD700] transition duration-150 ease-in-out">
                    <i class="fas fa-arrow-left mr-1"></i> Volver al inicio de sesión
                </a>
            </div>
        </form>
    </div>
</div>
@endsection