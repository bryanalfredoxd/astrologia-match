<!-- Header/Navbar -->
<header class="flex justify-between items-center mb-6 sm:mb-8">
    <div class="flex items-center space-x-2">
        <i class="fas fa-star-and-crescent text-2xl sm:text-3xl text-[#FFD700]"></i>
        <a href="{{ url('/astromatch') }}" class="text-xl sm:text-2xl font-bold">AstroMatch</a>
    </div>
    
    <div class="flex items-center space-x-4">
        <!-- Botón de Notificaciones - Mejorado -->
        <button class="w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center rounded-full bg-white bg-opacity-10 hover:bg-opacity-20 transition">
            <i class="fas fa-bell text-[#A7B3EB] text-sm sm:text-base"></i>
        </button>
        
        <!-- Menú de Perfil Desplegable -->
        <div class="relative">
            <!-- Botón del Perfil -->
            <button 
                id="profile-menu-button"
                class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-[#4A0E7B] flex items-center justify-center hover:bg-[#5A1E8B] transition"
            >
                <i class="fas fa-user-astronaut text-[#FFD700] text-sm sm:text-base"></i>
            </button>
            
            <!-- Menú Desplegable (oculto por defecto) -->
            <div 
                id="profile-menu"
                class="hidden absolute right-0 mt-2 w-48 bg-[#1A1F4D] rounded-md shadow-lg z-50 border border-[#4A0E7B]"
            >
                <div class="py-1">
                    <a 
                        href="#" 
                        class="block px-4 py-2 text-sm text-[#A7B3EB] hover:bg-[#4A0E7B] hover:text-white"
                    >
                        Mi Perfil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button 
                            type="submit"
                            class="w-full text-left block px-4 py-2 text-sm text-[#A7B3EB] hover:bg-[#4A0E7B] hover:text-white"
                        >
                            Salir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Script para manejar el menú desplegable -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profileButton = document.getElementById('profile-menu-button');
        const profileMenu = document.getElementById('profile-menu');
        
        // Alternar menú al hacer clic
        profileButton.addEventListener('click', function(e) {
            e.stopPropagation();
            profileMenu.classList.toggle('hidden');
        });
        
        // Cerrar menú al hacer clic fuera
        document.addEventListener('click', function() {
            profileMenu.classList.add('hidden');
        });
        
        // Prevenir que el clic en el menú lo cierre
        profileMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
</script>