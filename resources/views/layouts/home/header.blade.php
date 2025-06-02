<!-- HEADER -->
<!-- Barra de navegación optimizada para móviles -->
        <nav class="bg-astral text-white shadow-lg sticky top-0 z-50">
            <div class="container mx-auto px-4 py-3 flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-star text-yellow-300 text-xl md:text-2xl"></i>
                    <a href="{{ url('/') }}" class="text-lg md:text-xl font-bold">AstroMatch</a>
                </div>
                <div class="flex space-x-2">
                    <a href="#" class="px-3 py-1 md:px-4 md:py-2 text-sm md:text-base rounded-full bg-white text-blue-800 font-semibold hover:bg-blue-100">
                        Ingresar
                    </a>
                    <a href="{{ route('register') }}" class="px-3 py-1 md:px-4 md:py-2 text-sm md:text-base rounded-full bg-yellow-400 text-blue-900 font-semibold hover:bg-yellow-300">
                        Registro
                    </a>
                </div>
            </div>
        </nav>
    