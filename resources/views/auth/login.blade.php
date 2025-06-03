@extends('layouts.app')

@section('content')
<section class="bg-[#0A0E2A] text-white min-h-screen flex items-center justify-center p-4 sm:p-6 relative overflow-hidden">
    <div class="w-full max-w-md">
        <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl p-6 sm:p-8 w-full shadow-2xl">
            <!-- Logo/Cabecera -->
            <div class="text-center mb-6 sm:mb-8">
                <div class="flex justify-center mb-3 sm:mb-4">
                    <i class="fas fa-star-and-crescent text-4xl sm:text-5xl text-[#FFD700]"></i>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-[#FFD700] mb-1 sm:mb-2">Bienvenido de vuelta</h1>
                <p class="text-[#A7B3EB] text-sm sm:text-base">Ingresa tus datos para continuar tu viaje astral</p>
            </div>

            <!-- Formulario de Login -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4 sm:space-y-6">
                @csrf

                <!-- Campo Email -->
                <div>
                    <label for="email" class="block text-[#A7B3EB] text-xs sm:text-sm font-medium mb-1">Correo electrónico</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-[#A7B3EB] text-sm sm:text-base"></i>
                        </div>
                        <input id="email" type="email" name="email" required autocomplete="email"
                            class="input-field w-full pl-9 sm:pl-10 pr-3 py-2 text-sm sm:text-base bg-white bg-opacity-15 border border-[#4A0E7B] border-opacity-40 rounded-lg text-white placeholder-[#D6E3FF] focus:outline-none focus:border-transparent transition duration-200 ease-in-out @error('email') border-red-500 @enderror"
                            placeholder="tucorreo@universo.com">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Campo Contraseña -->
                <div>
                    <label for="password" class="block text-[#A7B3EB] text-xs sm:text-sm font-medium mb-1">Contraseña</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-[#A7B3EB] text-sm sm:text-base"></i>
                        </div>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="input-field w-full pl-9 sm:pl-10 pr-3 py-2 text-sm sm:text-base bg-white bg-opacity-15 border border-[#4A0E7B] border-opacity-40 rounded-lg text-white placeholder-[#D6E3FF] focus:outline-none focus:border-transparent transition duration-200 ease-in-out @error('password') border-red-500 @enderror"
                            placeholder="Tu contraseña segura">
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Recordar sesión y olvidé contraseña -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between space-y-3 sm:space-y-0">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-[#FFD700] focus:ring-[#FFD700] border-[#4A0E7B] rounded bg-white bg-opacity-15">
                        <label for="remember_me" class="ml-2 block text-xs sm:text-sm text-[#A7B3EB]">Recordar sesión</label>
                    </div>
                    <div class="text-xs sm:text-sm">
                        <a href="#" class="font-medium text-[#FFD700] hover:text-[#F8C800] transition duration-200">¿Olvidaste tu contraseña?</a>
                    </div>
                </div>

                <!-- Botón de Login -->
                <button type="submit" class="w-full flex justify-center items-center px-4 sm:px-6 py-2 sm:py-3 bg-[#FFD700] hover:bg-[#F8C800] text-[#0A0E2A] font-bold sm:font-extrabold rounded-full transition duration-300 text-base sm:text-lg transform hover:scale-105 shadow-lg hover:shadow-xl">
                    <i class="fas fa-door-open mr-2 sm:mr-3 text-lg sm:text-xl"></i> Iniciar Sesión
                </button>

                <!-- Divisor -->
                <div class="auth-divider text-xs sm:text-sm my-4 sm:my-6">O continúa con</div>

                <!-- Redes Sociales -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                    <a href="#" class="flex items-center justify-center px-3 sm:px-4 py-2 bg-[#3b5998] hover:bg-[#344e86] text-white rounded-lg transition duration-200 text-sm sm:text-base">
                        <i class="fab fa-facebook-f mr-2 text-sm sm:text-base"></i> Facebook
                    </a>
                    <a href="#" class="flex items-center justify-center px-3 sm:px-4 py-2 bg-[#4285F4] hover:bg-[#3367d6] text-white rounded-lg transition duration-200 text-sm sm:text-base">
                        <i class="fab fa-google mr-2 text-sm sm:text-base"></i> Google
                    </a>
                </div>
            </form>

            <!-- Enlace a Registro -->
            <div class="text-center pt-4 sm:pt-6">
                <p class="text-[#A7B3EB] text-xs sm:text-sm">¿No tienes una cuenta? 
                    <a href="{{ route('register') }}" class="text-[#FFD700] hover:text-[#F8C800] font-semibold transition duration-200 ease-in-out underline">Regístrate aquí</a>
                </p>
            </div>
        </div>
    </div>
</section>
@endsection