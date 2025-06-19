@extends('layouts.app_sesion')

@section('content')
<section class="bg-[#0A0E2A] text-white min-h-screen p-4 sm:p-6 relative overflow-hidden">
    @include('partials.header')

    <div class="max-w-4xl mx-auto">
        {{-- Pasar el usuario a la parcial profile-card --}}
        @include('partials.profile-card', ['user' => $user]) 
        {{-- ¡NUEVA TARJETA DE IMÁGENES AQUÍ! --}}
        @include('partials.profile-images-card', ['user' => $user])
        {{-- ¡NUEVA TARJETA DE TAGS AQUÍ! --}}
        @include('partials.profile-tags-card', ['user' => $user, 'masterTags' => $masterTags, 'userTagIds' => $userTagIds])
        @include('partials.lunar-sign-card', ['lunarSign' => $lunarSign])
        @include('partials.ascendant-sign-card', ['ascendantSign' => $ascendantSign])

        @include('partials.daily-tip')
    </div>

    @include('partials.desktop-nav')
    @include('partials.mobile-nav')
</section>

<style>
    /* Asegurar que el contenido no quede detrás de los menús fijos */
    @media (max-width: 640px) {
        body {
            padding-bottom: 72px; /* Altura de la barra de navegación móvil */
        }
    }
    @media (min-width: 641px) {
        body {
            padding-bottom: 64px; /* Altura del menú fijo desktop */
        }
    }

    /* Efecto de brillo para los iconos activos */
    .text-[#FFD700] {
        filter: drop-shadow(0 0 4px rgba(255, 215, 0, 0.4));
    }
</style>
@endsection