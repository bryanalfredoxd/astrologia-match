@extends('layouts.app')

@section('content')
<!-- Sección de Registro - Diseño mejorado para AstroMatch -->
<section class="bg-astral text-white min-h-screen flex items-center justify-center p-4">
    <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden w-full max-w-md">
        <!-- Encabezado con gradiente astral -->
        <div class="bg-astral p-6 text-center">
            <div class="flex justify-center mb-4">
                <i class="fas fa-star text-yellow-300 text-4xl"></i>
            </div>
            <h2 class="text-2xl font-bold">Registro Cósmico</h2>
            <p class="text-blue-100 mt-2">Completa tu carta astral para encontrar conexiones significativas</p>
        </div>

        <!-- Formulario de registro -->
        <div class="p-6">
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Grupo de datos personales -->
                <div class="space-y-4">
                    <!-- Nombre completo -->
                    <div>
                        <label for="nombre_completo" class="block text-blue-100 text-sm font-medium mb-1">Nombre completo</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-user text-blue-200"></i>
                            </div>
                            <input id="nombre_completo" type="text" name="nombre_completo" required
                                class="w-full pl-10 pr-3 py-2 bg-white bg-opacity-20 border border-blue-300 border-opacity-50 rounded-lg text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-transparent"
                                placeholder="Tu nombre completo">
                        </div>
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-blue-100 text-sm font-medium mb-1">Correo electrónico</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-blue-200"></i>
                            </div>
                            <input id="email" type="email" name="email" required
                                class="w-full pl-10 pr-3 py-2 bg-white bg-opacity-20 border border-blue-300 border-opacity-50 rounded-lg text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-transparent"
                                placeholder="tucorreo@universo.com">
                        </div>
                    </div>
                    
                    <!-- Contraseña -->
                    <div>
                        <label for="password" class="block text-blue-100 text-sm font-medium mb-1">Contraseña</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-blue-200"></i>
                            </div>
                            <input id="password" type="password" name="password" required
                                class="w-full pl-10 pr-3 py-2 bg-white bg-opacity-20 border border-blue-300 border-opacity-50 rounded-lg text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-transparent"
                                placeholder="Crea una contraseña segura">
                        </div>
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div>
                        <label for="password_confirmation" class="block text-blue-100 text-sm font-medium mb-1">Confirmar contraseña</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-lock text-blue-200"></i>
                            </div>
                            <input id="password_confirmation" type="password" name="password_confirmation" required
                                class="w-full pl-10 pr-3 py-2 bg-white bg-opacity-20 border border-blue-300 border-opacity-50 rounded-lg text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-transparent"
                                placeholder="Repite tu contraseña">
                        </div>
                    </div>
                </div>

                <!-- Grupo de datos astrológicos -->
                <div class="mt-6 space-y-4">
                    <h3 class="text-lg font-semibold text-yellow-300 mb-2 flex items-center">
                        <i class="fas fa-star mr-2"></i> Datos Astrológicos
                    </h3>
                    
                    <!-- Fecha de nacimiento -->
                    <div>
                        <label for="fecha_nacimiento" class="block text-blue-100 text-sm font-medium mb-1">Fecha de nacimiento</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-calendar-alt text-blue-200"></i>
                            </div>
                            <input id="fecha_nacimiento" type="date" name="fecha_nacimiento" required
                                class="w-full pl-10 pr-3 py-2 bg-white bg-opacity-20 border border-blue-300 border-opacity-50 rounded-lg text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-transparent">
                        </div>
                    </div>
                    
                    <!-- Hora de nacimiento -->
                    <div>
                        <label for="hora_nacimiento" class="block text-blue-100 text-sm font-medium mb-1">Hora de nacimiento</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-clock text-blue-200"></i>
                            </div>
                            <input id="hora_nacimiento" type="time" name="hora_nacimiento" required
                                class="w-full pl-10 pr-3 py-2 bg-white bg-opacity-20 border border-blue-300 border-opacity-50 rounded-lg text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-transparent">
                        </div>
                        <p class="text-xs text-blue-200 mt-1">Aproximada si no la recuerdas exactamente</p>
                    </div>
                    
                    <!-- Lugar de nacimiento -->
                    <div>
                        <label for="lugar_nacimiento" class="block text-blue-100 text-sm font-medium mb-1">Lugar de nacimiento</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-map-marker-alt text-blue-200"></i>
                            </div>
                            <input id="lugar_nacimiento" type="text" name="lugar_nacimiento" required
                                class="w-full pl-10 pr-3 py-2 bg-white bg-opacity-20 border border-blue-300 border-opacity-50 rounded-lg text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-transparent"
                                placeholder="Ciudad, País">
                        </div>
                        <p class="text-xs text-blue-200 mt-1">Para calcular tu ascendente con precisión</p>
                    </div>
                </div>

                <!-- Grupo de datos demográficos -->
                <div class="mt-6 space-y-4">
                    <h3 class="text-lg font-semibold text-yellow-300 mb-2 flex items-center">
                        <i class="fas fa-user-friends mr-2"></i> Sobre ti
                    </h3>
                    
                    <!-- Género -->
                    <div>
                        <label class="block text-blue-100 text-sm font-medium mb-1">Género</label>
                        <div class="grid grid-cols-3 gap-2">
                            <label class="flex items-center">
                                <input type="radio" name="genero" value="Masculino" required
                                    class="mr-2 text-yellow-400 focus:ring-yellow-300">
                                <span class="text-sm text-white">Masculino</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="genero" value="Femenino"
                                    class="mr-2 text-yellow-400 focus:ring-yellow-300">
                                <span class="text-sm text-white">Femenino</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="genero" value="Otro"
                                    class="mr-2 text-yellow-400 focus:ring-yellow-300">
                                <span class="text-sm text-white">Otro</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Orientación sexual -->
                    <div>
                        <label for="orientacion_sexual" class="block text-blue-100 text-sm font-medium mb-1">Orientación sexual</label>
                        <select id="orientacion_sexual" name="orientacion_sexual" required
                            class="w-full pl-3 py-2 bg-white bg-opacity-20 border border-blue-300 border-opacity-50 rounded-lg text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:border-transparent">
                            <option value="" disabled selected>Selecciona una opción</option>
                            <option value="Heterosexual">Heterosexual</option>
                            <option value="Homosexual">Homosexual</option>
                            <option value="Bisexual">Bisexual</option>
                            <option value="Pansexual">Pansexual</option>
                            <option value="Asexual">Asexual</option>
                        </select>
                    </div>
                </div>

                <!-- Botón de registro -->
                <button type="submit" class="w-full flex justify-center items-center px-6 py-3 bg-yellow-400 hover:bg-yellow-300 text-blue-900 font-bold rounded-full transition duration-300 mt-6">
                    <i class="fas fa-rocket mr-2"></i> Comenzar mi viaje astral
                </button>
                
                <!-- Enlace a login -->
                <div class="text-center pt-2">
                    <p class="text-blue-200 text-sm">¿Ya tienes una cuenta? 
                        <a href="#" class="text-yellow-300 hover:text-yellow-200 font-medium">Inicia sesión aquí</a>
                    </p>
                </div>
            </form>
        </div>
        
        <!-- Footer del formulario -->
        <div class="bg-blue-900 bg-opacity-30 p-4 text-center">
            <p class="text-xs text-blue-200">
                <i class="fas fa-shield-alt mr-1"></i> Tus datos astrales están protegidos bajo las estrellas
            </p>
        </div>
    </div>
</section>
@endsection