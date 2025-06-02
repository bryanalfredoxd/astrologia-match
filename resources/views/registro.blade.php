@extends('layouts.app')

@section('content')
<section class="bg-[#0A0E2A] text-white min-h-screen flex items-center justify-center p-4 py-8 relative overflow-hidden">
    {{-- Decorative elements for cosmic background (optional, for more flair) --}}
    <div class="absolute top-0 left-0 w-48 h-48 bg-[#4A0E7B] rounded-full mix-blend-screen opacity-10 blur-3xl animate-blob -z-10"></div>
    <div class="absolute bottom-0 right-0 w-48 h-48 bg-[#8A2BE2] rounded-full mix-blend-screen opacity-10 blur-3xl animate-blob animation-delay-2000 -z-10"></div>
    <div class="absolute top-1/4 left-1/4 w-32 h-32 bg-[#FFD700] rounded-full mix-blend-screen opacity-5 blur-3xl animate-blob animation-delay-4000 -z-10"></div>


    {{-- Container for the entire layout (cards + form) --}}
    {{-- Changed from flex-col lg:flex-row to ensure primary centering of the main content block --}}
    <div class="flex flex-col lg:flex-row items-center justify-center gap-32 w-full max-w-7xl mx-auto z-10"> {{-- Added z-10 to ensure content is above blobs --}}

        {{-- Left Zodiac Cards (hidden on mobile, visible on large screens and up, stacked vertically) --}}
        <div class="hidden lg:flex lg:flex-col lg:gap-4 flex-shrink-0 w-64"> {{-- Changed to flex-col and added fixed width --}}
            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center bg-opacity-10 backdrop-blur-sm border border-[#4A0E7B] border-opacity-40">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3 overflow-hidden">
                    <img src="{{ asset('images/zodiaco/aries.png') }}" alt="Aries" class="w-full h-full object-contain" loading="lazy">
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-white mb-1">Aries</h3>
                <p class="text-sm text-red-400 font-medium mb-1">Fuego - Cardinal</p>
                <p class="text-xs text-[#A7B3EB]">Mar 21 - Abr 19</p>
                <div class="mt-3">
                    <i class="fas fa-fire text-red-500 text-2xl md:text-3xl"></i>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center bg-opacity-10 backdrop-blur-sm border border-[#4A0E7B] border-opacity-40">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3 overflow-hidden">
                    <img src="{{ asset('images/zodiaco/taurus.png') }}" alt="Tauro" class="w-full h-full object-contain">
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-white mb-1">Tauro</h3>
                <p class="text-sm text-green-400 font-medium mb-1">Tierra - Fijo</p>
                <p class="text-xs text-[#A7B3EB]">Abr 20 - May 20</p>
                <div class="mt-3">
                    <i class="fas fa-leaf text-emerald-500 text-2xl md:text-3xl"></i>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center bg-opacity-10 backdrop-blur-sm border border-[#4A0E7B] border-opacity-40">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3 overflow-hidden">
                    <img src="{{ asset('images/zodiaco/gemini.png') }}" alt="Géminis" class="w-full h-full object-contain">
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-white mb-1">Géminis</h3>
                <p class="text-sm text-blue-400 font-medium mb-1">Aire - Mutable</p>
                <p class="text-xs text-[#A7B3EB]">May 21 - Jun 20</p>
                <div class="mt-3">
                    <i class="fas fa-wind text-blue-500 text-2xl md:text-3xl"></i>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center bg-opacity-10 backdrop-blur-sm border border-[#4A0E7B] border-opacity-40">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3 overflow-hidden">
                    <img src="{{ asset('images/zodiaco/cancer.png') }}" alt="Cáncer" class="w-full h-full object-contain">
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-white mb-1">Cáncer</h3>
                <p class="text-sm text-indigo-400 font-medium mb-1">Agua - Cardinal</p>
                <p class="text-xs text-[#A7B3EB]">Jun 21 - Jul 22</p>
                <div class="mt-3">
                    <i class="fas fa-water text-indigo-500 text-2xl md:text-3xl"></i>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center bg-opacity-10 backdrop-blur-sm border border-[#4A0E7B] border-opacity-40">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3 overflow-hidden">
                    <img src="{{ asset('images/zodiaco/leo.png') }}" alt="Leo" class="w-full h-full object-contain">
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-white mb-1">Leo</h3>
                <p class="text-sm text-yellow-400 font-medium mb-1">Fuego - Fijo</p>
                <p class="text-xs text-[#A7B3EB]">Jul 23 - Ago 22</p>
                <div class="mt-3">
                    <i class="fas fa-fire text-red-500 text-2xl md:text-3xl"></i>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center bg-opacity-10 backdrop-blur-sm border border-[#4A0E7B] border-opacity-40">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3 overflow-hidden">
                    <img src="{{ asset('images/zodiaco/virgo.png') }}" alt="Virgo" class="w-full h-full object-contain">
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-white mb-1">Virgo</h3>
                <p class="text-sm text-emerald-400 font-medium mb-1">Tierra - Mutable</p>
                <p class="text-xs text-[#A7B3EB]">Ago 23 - Sep 22</p>
                <div class="mt-3">
                    <i class="fas fa-leaf text-emerald-500 text-2xl md:text-3xl"></i>
                </div>
            </div>
        </div>

        {{-- Main Registration Form --}}
        <div class="bg-white bg-opacity-10 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden w-full max-w-lg border border-[#4A0E7B] border-opacity-40 flex-shrink-0">
            <div class="bg-astral-header p-8 text-center relative">
                <div class="flex justify-center mb-4">
                    <i class="fas fa-star text-[#FFD700] text-5xl animate-pulse"></i>
                </div>
                <h2 class="text-3xl font-extrabold tracking-wide drop-shadow-lg">Registro Cósmico</h2>
                <p class="text-[#A7B3EB] mt-2 text-lg font-light">Completa tu carta astral para encontrar conexiones significativas</p>
                <div class="absolute inset-x-0 bottom-0 h-1 bg-[#FFD700] opacity-70"></div>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <div class="space-y-5">
                        <h3 class="text-xl font-semibold text-[#FFD700] flex items-center mb-3 border-b border-[#FFD700] border-opacity-50 pb-2">
                            <i class="fas fa-user-circle mr-3 text-[#F8C800]"></i> Información Personal
                        </h3>
                        <div>
                            <label for="nombre_completo" class="block text-[#A7B3EB] text-sm font-medium mb-1">Nombre completo</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-[#A7B3EB]"></i>
                                </div>
                                <input id="nombre_completo" type="text" name="nombre_completo" required autocomplete="name"
                                    class="w-full pl-10 pr-3 py-2 bg-white bg-opacity-15 border border-[#4A0E7B] border-opacity-40 rounded-lg text-white placeholder-[#D6E3FF] focus:outline-none focus:ring-2 focus:ring-[#FFD700] focus:border-transparent transition duration-200 ease-in-out @error('nombre_completo') border-red-500 @enderror"
                                    placeholder="Tu nombre completo">
                                @error('nombre_completo')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="email" class="block text-[#A7B3EB] text-sm font-medium mb-1">Correo electrónico</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-[#A7B3EB]"></i>
                                </div>
                                <input id="email" type="email" name="email" required autocomplete="email"
                                    class="w-full pl-10 pr-3 py-2 bg-white bg-opacity-15 border border-[#4A0E7B] border-opacity-40 rounded-lg text-white placeholder-[#D6E3FF] focus:outline-none focus:ring-2 focus:ring-[#FFD700] focus:border-transparent transition duration-200 ease-in-out @error('email') border-red-500 @enderror"
                                    placeholder="tucorreo@universo.com">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="password" class="block text-[#A7B3EB] text-sm font-medium mb-1">Contraseña</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-[#A7B3EB]"></i>
                                </div>
                                <input id="password" type="password" name="password" required autocomplete="new-password"
                                    class="w-full pl-10 pr-3 py-2 bg-white bg-opacity-15 border border-[#4A0E7B] border-opacity-40 rounded-lg text-white placeholder-[#D6E3FF] focus:outline-none focus:ring-2 focus:ring-[#FFD700] focus:border-transparent transition duration-200 ease-in-out @error('password') border-red-500 @enderror"
                                    placeholder="Crea una contraseña segura">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 space-y-5">
                        <h3 class="text-xl font-semibold text-[#FFD700] flex items-center mb-3 border-b border-[#FFD700] border-opacity-50 pb-2">
                            <i class="fas fa-star-of-life mr-3 text-[#F8C800]"></i> Datos Astrológicos
                        </h3>
                        
                        <div>
                            <label for="fecha_nacimiento" class="block text-[#A7B3EB] text-sm font-medium mb-1">Fecha de nacimiento</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-alt text-[#A7B3EB]"></i>
                                </div>
                                <input id="fecha_nacimiento" type="date" name="fecha_nacimiento" required
                                    class="w-full pl-10 pr-3 py-2 bg-white bg-opacity-15 border border-[#4A0E7B] border-opacity-40 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-[#FFD700] focus:border-transparent transition duration-200 ease-in-out appearance-none date-input @error('fecha_nacimiento') border-red-500 @enderror">
                                @error('fecha_nacimiento')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div>
                            <label for="hora_nacimiento" class="block text-[#A7B3EB] text-sm font-medium mb-1">Hora de nacimiento</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-clock text-[#A7B3EB]"></i>
                                </div>
                                <input id="hora_nacimiento" type="time" name="hora_nacimiento" required
                                    class="w-full pl-10 pr-3 py-2 bg-white bg-opacity-15 border border-[#4A0E7B] border-opacity-40 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-[#FFD700] focus:border-transparent transition duration-200 ease-in-out @error('hora_nacimiento') border-red-500 @enderror">
                            </div>
                            <p class="text-xs text-[#A7B3EB] mt-1">Aproximada si no la recuerdas exactamente</p>
                            @error('hora_nacimiento')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="lugar_nacimiento" class="block text-[#A7B3EB] text-sm font-medium mb-1">Lugar de nacimiento (Venezuela)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-map-marker-alt text-[#A7B3EB]"></i>
                                </div>
                                <input list="ciudades_venezuela" id="lugar_nacimiento" type="text" name="lugar_nacimiento" required
                                    class="w-full pl-10 pr-3 py-2 bg-white bg-opacity-15 border border-[#4A0E7B] border-opacity-40 rounded-lg text-white placeholder-[#D6E3FF] focus:outline-none focus:ring-2 focus:ring-[#FFD700] focus:border-transparent transition duration-200 ease-in-out @error('lugar_nacimiento') border-red-500 @enderror"
                                    placeholder="Escribe o selecciona tu ciudad">
                                <datalist id="ciudades_venezuela">
                                    <option value="Caracas">
                                    <option value="Maracaibo">
                                    <option value="Valencia">
                                    <option value="Barquisimeto">
                                    <option value="Maracay">
                                    <option value="Ciudad Guayana">
                                    <option value="San Cristóbal">
                                    <option value="Maturín">
                                    <option value="Barcelona">
                                    <option value="Puerto La Cruz">
                                    <option value="Mérida">
                                    <option value="Cumana">
                                    <option value="Coro">
                                    <option value="Barinas">
                                    <option value="Cabimas">
                                    <option value="Punto Fijo">
                                    <option value="La Guaira">
                                    <option value="Cumaná">
                                    <option value="Ciudad Bolívar">
                                    <option value="Valera">
                                    <option value="Los Teques">
                                    <option value="Guarenas">
                                    <option value="Guatire">
                                    <option value="Acarigua">
                                    <option value="Araure">
                                    <option value="El Tigre">
                                    <option value="San Fernando de Apure">
                                    <option value="Puerto Cabello">
                                    <option value="Anaco">
                                    <option value="Calabozo">
                                    <option value="Ejido">
                                    <option value="Charallave">
                                    <option value="Ocumare del Tuy">
                                    <option value="Cúa">
                                    <option value="San Felipe">
                                    <option value="Tinaquillo">
                                    <option value="Quíbor">
                                    <option value="Upata">
                                    <option value="Carúpano">
                                    <option value="San Carlos">
                                    <option value="Tucupita">
                                    <option value="San Juan de los Morros">
                                    <option value="La Victoria">
                                    <option value="Villa de Cura">
                                    <option value="Chivacoa">
                                    <option value="Zaraza">
                                    <option value="Machiques">
                                    <option value="Santa Rita">
                                    <option value="Machiques de Perijá">
                                    <option value="Puerto Ayacucho">
                                    <option value="Guasdualito">
                                    <option value="Bocono">
                                    <option value="San Antonio del Táchira">
                                    <option value="Rubio">
                                    <option value="Colon">
                                    <option value="Santa Elena de Uairén">
                                </datalist>
                            </div>
                            <p class="text-xs text-[#A7B3EB] mt-1">Para calcular tu ascendente con precisión</p>
                            @error('lugar_nacimiento')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-8 space-y-5">
                        <h3 class="text-xl font-semibold text-[#FFD700] flex items-center mb-3 border-b border-[#FFD700] border-opacity-50 pb-2">
                            <i class="fas fa-users-cog mr-3 text-[#F8C800]"></i> Sobre ti
                        </h3>
                        
                        <div>
                            <label class="block text-[#A7B3EB] text-sm font-medium mb-1">Género</label>
                            <div class="flex justify-center space-x-10">
                                <label class="flex flex-col items-center cursor-pointer text-center">
                                    <input type="radio" name="genero" value="Masculino" required
                                        class="form-radio h-5 w-5 text-[#FFD700] focus:ring-[#FFD700] transition duration-150 ease-in-out @error('genero') border-red-500 @enderror">
                                    <i class="fas fa-mars text-[#A7B3EB] text-2xl mt-1"></i>
                                    <span class="ml-2 text-white text-base mt-1">Masculino</span>
                                </label>
                                <label class="flex flex-col items-center cursor-pointer text-center">
                                    <input type="radio" name="genero" value="Femenino"
                                        class="form-radio h-5 w-5 text-[#FFD700] focus:ring-[#FFD700] transition duration-150 ease-in-out @error('genero') border-red-500 @enderror">
                                    <i class="fas fa-venus text-[#FFEB3B] text-2xl mt-1"></i>
                                    <span class="ml-2 text-white text-base mt-1">Femenino</span>
                                </label>
                            </div>
                            @error('genero')
                                <p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="orientacion_sexual" class="block text-[#A7B3EB] text-sm font-medium mb-1">Orientación sexual</label>
                            <select id="orientacion_sexual" name="orientacion_sexual" required
                                class="w-full pl-3 pr-10 py-2 bg-white bg-opacity-15 border border-[#4A0E7B] border-opacity-40 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-[#FFD700] focus:border-transparent transition duration-200 ease-in-out custom-select @error('orientacion_sexual') border-red-500 @enderror">
                                <option value="" disabled selected class="bg-[#0A0E2A] text-[#A7B3EB]">Selecciona una opción</option>
                                <option value="Heterosexual" class="bg-[#0A0E2A] text-white">Heterosexual</option>
                                <option value="Homosexual" class="bg-[#0A0E2A] text-white">Homosexual</option>
                                <option value="Bisexual" class="bg-[#0A0E2A] text-white">Bisexual</option>
                                <option value="Pansexual" class="bg-[#0A0E2A] text-white">Pansexual</option>
                                <option value="Asexual" class="bg-[#0A0E2A] text-white">Asexual</option>
                            </select>
                            @error('orientacion_sexual')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="w-full flex justify-center items-center px-6 py-3 bg-[#FFD700] hover:bg-[#F8C800] text-[#0A0E2A] font-extrabold rounded-full transition duration-300 mt-8 text-lg transform hover:scale-105 shadow-lg hover:shadow-xl">
                        <i class="fas fa-rocket mr-3 text-xl"></i> ¡Comenzar mi viaje astral!
                    </button>
                    
                    <div class="text-center pt-4">
                        <p class="text-[#A7B3EB] text-sm">¿Ya tienes una cuenta? 
                            <a href="#" class="text-[#FFD700] hover:text-[#F8C800] font-semibold transition duration-200 ease-in-out underline">Inicia sesión aquí</a>
                        </p>
                    </div>
                </form>
            </div>
            
            <div class="bg-[#2D095C] bg-opacity-30 p-4 text-center rounded-b-2xl border-t border-[#4A0E7B] border-opacity-20">
                <p class="text-xs text-[#A7B3EB] font-light">
                    <i class="fas fa-shield-alt mr-1 text-[#A7B3EB]"></i> Tus datos astrales están protegidos bajo las estrellas
                </p>
            </div>
        </div>

        {{-- Right Zodiac Cards (hidden on mobile, visible on large screens and up, stacked vertically) --}}
        <div class="hidden lg:flex lg:flex-col lg:gap-4 flex-shrink-0 w-64"> {{-- Changed to flex-col and added fixed width --}}
            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center bg-opacity-10 backdrop-blur-sm border border-[#4A0E7B] border-opacity-40">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3 overflow-hidden">
                    <img src="{{ asset('images/zodiaco/libra.png') }}" alt="Libra" class="w-full h-full object-contain">
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-white mb-1">Libra</h3>
                <p class="text-sm text-blue-400 font-medium mb-1">Aire - Cardinal</p>
                <p class="text-xs text-[#A7B3EB]">Sep 23 - Oct 22</p>
                <div class="mt-3">
                    <i class="fas fa-wind text-blue-500 text-2xl md:text-3xl"></i>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center bg-opacity-10 backdrop-blur-sm border border-[#4A0E7B] border-opacity-40">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3 overflow-hidden">
                    <img src="{{ asset('images/zodiaco/scorpio.png') }}" alt="Scorpio" class="w-full h-full object-contain">
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-white mb-1">Escorpio</h3>
                <p class="text-sm text-indigo-400 font-medium mb-1">Agua - Fijo</p>
                <p class="text-xs text-[#A7B3EB]">Oct 23 - Nov 21</p>
                <div class="mt-3">
                    <i class="fas fa-water text-indigo-500 text-2xl md:text-3xl"></i>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center bg-opacity-10 backdrop-blur-sm border border-[#4A0E7B] border-opacity-40">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3 overflow-hidden">
                    <img src="{{ asset('images/zodiaco/sagittarius.png') }}" alt="Sagittarius" class="w-full h-full object-contain">
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-white mb-1">Sagitario</h3>
                <p class="text-sm text-red-400 font-medium mb-1">Fuego - Mutable</p>
                <p class="text-xs text-[#A7B3EB]">Nov 22 - Dic 21</p>
                <div class="mt-3">
                    <i class="fas fa-fire text-red-500 text-2xl md:text-3xl"></i>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center bg-opacity-10 backdrop-blur-sm border border-[#4A0E7B] border-opacity-40">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3 overflow-hidden">
                    <img src="{{ asset('images/zodiaco/capricorn.png') }}" alt="Capricorn" class="w-full h-full object-contain">
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-white mb-1">Capricornio</h3>
                <p class="text-sm text-green-400 font-medium mb-1">Tierra - Cardinal</p>
                <p class="text-xs text-[#A7B3EB]">Dic 22 - Ene 19</p>
                <div class="mt-3">
                    <i class="fas fa-leaf text-emerald-500 text-2xl md:text-3xl"></i>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center bg-opacity-10 backdrop-blur-sm border border-[#4A0E7B] border-opacity-40">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3 overflow-hidden">
                    <img src="{{ asset('images/zodiaco/aquarius.png') }}" alt="Aquarius" class="w-full h-full object-contain">
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-white mb-1">Acuario</h3>
                <p class="text-sm text-blue-400 font-medium mb-1">Aire - Fijo</p>
                <p class="text-xs text-[#A7B3EB]">Ene 20 - Feb 18</p>
                <div class="mt-3">
                    <i class="fas fa-wind text-blue-500 text-2xl md:text-3xl"></i>
                </div>
            </div>
            
            <div class="bg-white p-4 rounded-xl shadow-md hover:shadow-lg transition-transform duration-300 hover:-translate-y-1 text-center bg-opacity-10 backdrop-blur-sm border border-[#4A0E7B] border-opacity-40">
                <div class="w-16 h-16 md:w-20 md:h-20 rounded-full flex items-center justify-center mx-auto mb-3 overflow-hidden">
                    <img src="{{ asset('images/zodiaco/pisces.png') }}" alt="Pisces" class="w-full h-full object-contain">
                </div>
                <h3 class="text-lg md:text-xl font-semibold text-white mb-1">Piscis</h3>
                <p class="text-sm text-indigo-400 font-medium mb-1">Agua - Mutable</p>
                <p class="text-xs text-[#A7B3EB]">Feb 19 - Mar 20</p>
                <div class="mt-3">
                    <i class="fas fa-water text-indigo-500 text-2xl md:text-3xl"></i>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* New gradient for the header to differentiate from the background */
    .bg-astral-header {
        background: linear-gradient(135deg, #4A0E7B 0%, #2D095C 50%, #8A2BE2 100%);
        background-size: 200% 200%;
        animation: gradientAnimation 15s ease infinite;
    }

    @keyframes gradientAnimation {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Estilo para que el placeholder y texto de input type="date" y "time" sean blancos */
    input[type="date"], input[type="time"] {
        color: white; /* Color del texto cuando se selecciona una fecha/hora */
    }

    /* Estilo para el placeholder en Chrome, Safari, Edge */
    input[type="date"]::placeholder, input[type="time"]::placeholder {
        color: #D6E3FF; /* new placeholder color */
        opacity: 1; /* Para Firefox */
    }

    /* Estilo para el texto de la fecha y hora seleccionada en Safari */
    input[type="date"]::-webkit-datetime-edit,
    input[type="time"]::-webkit-datetime-edit {
        color: white;
    }

    /* Ocultar el ícono del calendario/reloj por defecto en algunos navegadores */
    input[type="date"]::-webkit-calendar-picker-indicator,
    input[type="time"]::-webkit-calendar-picker-indicator {
        filter: invert(1); /* Para que el ícono se vea blanco en fondos oscuros */
        cursor: pointer;
    }

    /* Estilo para el select box */
    .custom-select {
        color: white;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        /* Update arrow color to match new palette */
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%23A7B3EB'%3E%3Cpath fill-rule='evenodd' d='M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z' clip-rule='evenodd'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1.5em 1.5em;
    }

    /* Estilo para las opciones del select */
    .custom-select option {
        background-color: #0A0E2A; /* Match new background color */
        color: white;
    }

    /* Para que el radio button sea visible y con el color correcto */
    input[type="radio"] {
        accent-color: #FFD700; /* New yellow/gold accent color */
    }

    /* Animated background blobs for extra cosmic effect */
    @keyframes animateBlob {
        0% {
            transform: translate(0, 0) scale(1);
        }
        33% {
            transform: translate(30px, -50px) scale(1.1);
        }
        66% {
            transform: translate(-20px, 20px) scale(0.9);
        }
        100% {
            transform: translate(0, 0) scale(1);
        }
    }
    .animate-blob {
        animation: animateBlob 7s infinite ease-in-out;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    .animation-delay-4000 {
        animation-delay: 4s;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateInput = document.getElementById('fecha_nacimiento');
        const timeInput = document.getElementById('hora_nacimiento');

        function updateInputColor(inputElement) {
            if (inputElement.value) {
                inputElement.style.color = 'white';
            } else {
                inputElement.style.color = '#D6E3FF'; // New placeholder color
            }
        }

        dateInput.addEventListener('change', () => updateInputColor(dateInput));
        timeInput.addEventListener('change', () => updateInputColor(timeInput));

        updateInputColor(dateInput);
        updateInputColor(timeInput);
    });
</script>
@endpush