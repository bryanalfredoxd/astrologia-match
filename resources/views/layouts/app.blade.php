<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstroMatch - @yield('title', 'Encuentra tu conexión cósmica')</title>
    
    {{-- Aquí activamos la PWA --}}
    @laravelPWA

    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('styles') 
</head>
<body>
    @include('layouts.header')

    <main style="margin-top: 80px;"> {{-- Espacio para el navbar fijo --}}
        @yield('content')
    </main>

    @include('layouts.footer')

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
        
        
    </script>
    

    @stack('scripts')
</body>
</html>
