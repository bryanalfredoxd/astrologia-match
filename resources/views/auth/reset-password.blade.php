@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-[#1A1F4D] to-[#4A0E7B] p-4 sm:p-6">
    <div class="w-full max-w-md px-4 py-8 sm:px-8 sm:py-12 bg-[#0A0E2A] bg-opacity-90 backdrop-blur-sm rounded-xl sm:rounded-2xl shadow-lg">
        <div class="flex justify-center mb-6 sm:mb-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-center text-[#FFD700]">
                <i class="fas fa-lock-open mr-2"></i> Restablecer Contraseña
            </h2>
        </div>

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4 sm:space-y-6">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label for="email-display" class="block text-xs sm:text-sm font-medium text-[#A7B3EB]">Correo Electrónico</label>
                <div class="mt-1 flex items-center px-3 py-2 sm:px-4 sm:py-3 bg-[#1A1F4D] border border-[#4A0E7B] rounded-lg text-[#A7B3EB]">
                    <span class="flex-grow">{{ $email ?? old('email') }}</span>
                    <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
                    <i class="fas fa-lock text-[#FFD700] ml-2"></i>
                </div>
                @error('email')
                    <span class="mt-1 text-xs sm:text-sm text-red-400">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-xs sm:text-sm font-medium text-[#A7B3EB]">Nueva Contraseña</label>
                <div class="relative">
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="mt-1 block w-full px-3 py-2 sm:px-4 sm:py-3 text-xs sm:text-sm bg-[#1A1F4D] border border-[#4A0E7B] rounded-lg text-[#A7B3EB] placeholder-[#4A0E7B] focus:outline-none focus:ring-2 focus:ring-[#FFD700] focus:border-transparent @error('password') border-red-500 @enderror">
                    <button type="button" onclick="togglePasswordVisibility('password')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#A7B3EB] hover:text-[#FFD700]">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
                @error('password')
                    <span class="mt-1 text-xs sm:text-sm text-red-400">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="password-confirm" class="block text-xs sm:text-sm font-medium text-[#A7B3EB]">Confirmar Contraseña</label>
                <div class="relative">
                    <input id="password-confirm" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="mt-1 block w-full px-3 py-2 sm:px-4 sm:py-3 text-xs sm:text-sm bg-[#1A1F4D] border border-[#4A0E7B] rounded-lg text-[#A7B3EB] placeholder-[#4A0E7B] focus:outline-none focus:ring-2 focus:ring-[#FFD700] focus:border-transparent">
                    <button type="button" onclick="togglePasswordVisibility('password-confirm')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-[#A7B3EB] hover:text-[#FFD700]">
                        <i class="far fa-eye"></i>
                    </button>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-3 sm:py-3 sm:px-4 border border-transparent rounded-lg shadow-sm text-xs sm:text-sm font-medium text-[#0A0E2A] bg-[#FFD700] hover:bg-[#FFC000] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#FFD700] transition duration-150 ease-in-out">
                    Restablecer Contraseña
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function togglePasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = field.nextElementSibling.querySelector('i');
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>
@endsection