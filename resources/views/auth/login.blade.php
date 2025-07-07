@extends('layouts.app')

@section('content')
@php
    // Define all 12 zodiac signs with their data
    $zodiacSigns = [
        [
            'name' => 'Aries',
            'image' => 'aries.png',
            'element' => 'Fuego',
            'quality' => 'Cardinal',
            'dates' => 'Mar 21 - Abr 19',
            'element_icon' => 'fas fa-fire',
            'element_color' => 'text-red-500'
        ],
        [
            'name' => 'Tauro',
            'image' => 'tauro.png',
            'element' => 'Tierra',
            'quality' => 'Fijo',
            'dates' => 'Abr 20 - May 20',
            'element_icon' => 'fas fa-leaf',
            'element_color' => 'text-emerald-500'
        ],
        [
            'name' => 'Géminis',
            'image' => 'géminis.png',
            'element' => 'Aire',
            'quality' => 'Mutable',
            'dates' => 'May 21 - Jun 20',
            'element_icon' => 'fas fa-wind',
            'element_color' => 'text-blue-500'
        ],
        [
            'name' => 'Cáncer',
            'image' => 'cáncer.png',
            'element' => 'Agua',
            'quality' => 'Cardinal',
            'dates' => 'Jun 21 - Jul 22',
            'element_icon' => 'fas fa-water',
            'element_color' => 'text-indigo-500'
        ],
        [
            'name' => 'Leo',
            'image' => 'leo.png',
            'element' => 'Fuego',
            'quality' => 'Fijo',
            'dates' => 'Jul 23 - Ago 22',
            'element_icon' => 'fas fa-fire',
            'element_color' => 'text-red-500'
        ],
        [
            'name' => 'Virgo',
            'image' => 'virgo.png',
            'element' => 'Tierra',
            'quality' => 'Mutable',
            'dates' => 'Ago 23 - Sep 22',
            'element_icon' => 'fas fa-leaf',
            'element_color' => 'text-emerald-500'
        ],
        [
            'name' => 'Libra',
            'image' => 'libra.png',
            'element' => 'Aire',
            'quality' => 'Cardinal',
            'dates' => 'Sep 23 - Oct 22',
            'element_icon' => 'fas fa-wind',
            'element_color' => 'text-blue-500'
        ],
        [
            'name' => 'Escorpio',
            'image' => 'escorpio.png',
            'element' => 'Agua',
            'quality' => 'Fijo',
            'dates' => 'Oct 23 - Nov 21',
            'element_icon' => 'fas fa-water',
            'element_color' => 'text-indigo-500'
        ],
        [
            'name' => 'Sagitario',
            'image' => 'sagitario.png',
            'element' => 'Fuego',
            'quality' => 'Mutable',
            'dates' => 'Nov 22 - Dic 21',
            'element_icon' => 'fas fa-fire',
            'element_color' => 'text-red-500'
        ],
        [
            'name' => 'Capricornio',
            'image' => 'capricornio.png',
            'element' => 'Tierra',
            'quality' => 'Cardinal',
            'dates' => 'Dic 22 - Ene 19',
            'element_icon' => 'fas fa-leaf',
            'element_color' => 'text-emerald-500'
        ],
        [
            'name' => 'Acuario',
            'image' => 'acuario.png',
            'element' => 'Aire',
            'quality' => 'Fijo',
            'dates' => 'Ene 20 - Feb 18',
            'element_icon' => 'fas fa-wind',
            'element_color' => 'text-blue-500'
        ],
        [
            'name' => 'Piscis',
            'image' => 'piscis.png',
            'element' => 'Agua',
            'quality' => 'Mutable',
            'dates' => 'Feb 19 - Mar 20',
            'element_icon' => 'fas fa-water',
            'element_color' => 'text-indigo-500'
        ],
    ];

    // Shuffle the array to randomize the order
    shuffle($zodiacSigns);

    // Get the first 6 elements
    $randomZodiacs = array_slice($zodiacSigns, 0, 6);

    // Split into two groups of 3
    $leftZodiacs = array_slice($randomZodiacs, 0, 3);
    $rightZodiacs = array_slice($randomZodiacs, 3, 3);
@endphp

<section class="bg-gradient-to-br from-[#1e3a8a] via-[#3b82f6] to-[#9333ea] text-white min-h-screen flex items-center justify-center p-4 sm:p-6 relative overflow-hidden">
    <div class="absolute inset-0 overflow-hidden -z-10">
        <div class="absolute top-10 left-1/4 w-1 h-1 bg-white rounded-full opacity-70"></div>
        <div class="absolute top-20 right-1/4 w-1 h-1 bg-white rounded-full opacity-70"></div>
        <div class="absolute bottom-1/3 left-1/3 w-1 h-1 bg-white rounded-full opacity-70"></div>
        <div class="absolute top-1/2 right-1/2 w-1 h-1 bg-white rounded-full opacity-70"></div>
        <div class="absolute bottom-20 left-20 w-1 h-1 bg-white rounded-full opacity-70"></div>
        <div class="absolute top-32 right-32 w-1 h-1 bg-white rounded-full opacity-70"></div>
    </div>

    <div class="absolute top-0 left-0 w-64 h-64 bg-[#4A0E7B] rounded-full mix-blend-screen opacity-10 blur-3xl animate-blob -z-10"></div>
    <div class="absolute bottom-0 right-0 w-64 h-64 bg-[#8A2BE2] rounded-full mix-blend-screen opacity-10 blur-3xl animate-blob animation-delay-2000 -z-10"></div>
    <div class="absolute top-1/4 left-1/4 w-40 h-40 bg-[#FFD700] rounded-full mix-blend-screen opacity-5 blur-3xl animate-blob animation-delay-4000 -z-10"></div>

    <div class="flex flex-col lg:flex-row items-center justify-center gap-32 w-full max-w-7xl mx-auto z-10"> {{-- Added z-10 to ensure content is above blobs --}}

        {{-- Left Zodiac Cards (hidden on mobile, visible on large screens and up, stacked vertically) --}}
        <div class="hidden lg:flex lg:flex-col lg:gap-4 flex-shrink-0 w-64">
            @foreach($leftZodiacs as $sign)
                <div class="bg-[#0A0E2A] p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center bg-opacity-50 backdrop-blur-sm border border-[#4A0E7B] border-opacity-40">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3 overflow-hidden">
                        <img src="{{ asset('images/zodiaco/' . $sign['image']) }}" alt="{{ $sign['name'] }}" class="w-full h-full object-contain" loading="lazy">
                    </div>
                    <h3 class="text-lg md:text-xl font-semibold text-white mb-1">{{ $sign['name'] }}</h3>
                    <p class="text-sm {{ $sign['element_color'] }} font-medium mb-1">{{ $sign['element'] }} - {{ $sign['quality'] }}</p>
                    <p class="text-xs text-[#A7B3EB]">{{ $sign['dates'] }}</p>
                    <div class="mt-3">
                        <i class="{{ $sign['element_icon'] }} {{ $sign['element_color'] }} text-2xl md:text-3xl"></i>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="w-full max-w-md mx-auto relative z-10 animate-fade-in">
            <div class="bg-[#0A0E2A] rounded-2xl p-8 shadow-2xl border border-[#4A0E7B]">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 mx-auto mb-4 flex items-center justify-center bg-[#FFD700]/10 rounded-full border border-[#FFD700]/30">
                        <i class="fas fa-star-and-crescent text-3xl text-[#FFD700]"></i>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-bold text-[#FFD700] mb-2">Bienvenido de vuelta</h1>
                    <p class="text-[#E0E7FF] text-sm">Ingresa tus datos para continuar tu viaje astral</p>
                </div>
        
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
        
                    <div>
                        <label for="email" class="block text-[#E0E7FF] text-sm font-medium mb-2">Correo electrónico</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-[#A7B3EB]"></i>
                            </div>
                            <input id="email" type="email" name="email" required autocomplete="email"
                                class="w-full pl-10 pr-4 py-3 bg-[#1A1F3D] border border-[#4A0E7B] rounded-lg text-white placeholder-[#A7B3EB] focus:outline-none focus:ring-2 focus:ring-[#FFD700]/50 focus:border-transparent transition duration-200 @error('email') border-red-500 @enderror"
                                placeholder="tucorreo@universo.com">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
        
                    <div>
                        <label for="password" class="block text-[#E0E7FF] text-sm font-medium mb-2">Contraseña</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-[#A7B3EB]"></i>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                class="w-full pl-10 pr-4 py-3 bg-[#1A1F3D] border border-[#4A0E7B] rounded-lg text-white placeholder-[#A7B3EB] focus:outline-none focus:ring-2 focus:ring-[#FFD700]/50 focus:border-transparent transition duration-200 @error('password') border-red-500 @enderror"
                                placeholder="Tu contraseña segura">
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
        
                    <!-- Sección modificada para centrado responsive -->
                    <div class="flex flex-col items-center space-y-3 sm:flex-row sm:space-y-0 sm:justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-[#FFD700] focus:ring-[#FFD700] border-[#4A0E7B] rounded bg-[#1A1F3D]">
                            <label for="remember_me" class="ml-2 block text-sm text-[#E0E7FF]">Recordar sesión</label>
                        </div>
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}" class="font-medium text-[#FFD700] hover:text-[#F8C800] transition">¿Olvidaste tu contraseña?</a>
                        </div>
                    </div>
        
                    <button type="submit" class="w-full flex justify-center items-center px-6 py-3 bg-gradient-to-r from-[#FFD700] to-[#F8C800] text-[#0A0E2A] font-bold rounded-full transition duration-300 hover:shadow-lg hover:shadow-[#FFD700]/30 mt-6">
                        <i class="fas fa-door-open mr-2"></i> Iniciar Sesión
                    </button>
                </form>
        
                <div class="text-center pt-6 mt-6 border-t border-[#4A0E7B]/40">
                    <p class="text-[#E0E7FF] text-sm">¿No tienes una cuenta?
                        <a href="{{ route('register') }}" class="text-[#FFD700] hover:text-[#F8C800] font-semibold transition underline">Regístrate aquí</a>
                    </p>
                </div>
            </div>
        </div>

        {{-- Right Zodiac Cards (hidden on mobile, visible on large screens and up, stacked vertically) --}}
        <div class="hidden lg:flex lg:flex-col lg:gap-4 flex-shrink-0 w-64">
            @foreach($rightZodiacs as $sign)
                <div class="bg-[#0A0E2A] p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center bg-opacity-50 backdrop-blur-sm border border-[#4A0E7B] border-opacity-40">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3 overflow-hidden">
                        <img src="{{ asset('images/zodiaco/' . $sign['image']) }}" alt="{{ $sign['name'] }}" class="w-full h-full object-contain" loading="lazy">
                    </div>
                    <h3 class="text-lg md:text-xl font-semibold text-white mb-1">{{ $sign['name'] }}</h3>
                    <p class="text-sm {{ $sign['element_color'] }} font-medium mb-1">{{ $sign['element'] }} - {{ $sign['quality'] }}</p>
                    <p class="text-xs text-[#A7B3EB]">{{ $sign['dates'] }}</p>
                    <div class="mt-3">
                        <i class="{{ $sign['element_icon'] }} {{ $sign['element_color'] }} text-2xl md:text-3xl"></i>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
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