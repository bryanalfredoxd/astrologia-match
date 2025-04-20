<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AstroMatch - Encuentra tu conexión cósmica</title>

    {{-- Aquí activamos la PWA --}}
    @laravelPWA
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
    <style>
        body {
            background-color: #1A1A40;
            color: #FFFFFF;
        }
        .btn-primary {
            background-color: #7F00FF;
            border-color: #7F00FF;
        }
        .btn-primary:hover {
            background-color: #3A0CA3;
            border-color: #3A0CA3;
        }
        .section-title {
            color: #F5C518;
        }
        footer {
            background-color: #0f0f25;
            color: #ccc;
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
        <div class="container">
            <a class="navbar-brand fw-bold text-warning" href="#">
                <i class="bi bi-stars"></i> AstroMatch
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="text-center py-5" style="background: linear-gradient(to right, #1A1A40, #3A0CA3);">
        <div class="container" data-aos="fade-up">
            <h1 class="display-4 fw-bold text-light">Conecta con tu alma gemela... ¡Astrológicamente!</h1>
            <p class="lead text-light">Descubre conexiones profundas basadas en tu carta astral.</p>
            <a href="#" class="btn btn-primary btn-lg mt-3"><i class="bi bi-star-fill"></i> Comienza tu viaje cósmico</a>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title text-center mb-4" data-aos="zoom-in">¿Qué te ofrece AstroMatch?</h2>
            <div class="row text-center">
                <div class="col-md-4 mb-4" data-aos="fade-right">
                    <i class="bi bi-moon-stars fs-1 text-warning mb-2"></i>
                    <h5>Emparejamiento Astrológico</h5>
                    <p>Basado en signos solares, lunares y ascendentes.</p>
                </div>
                <div class="col-md-4 mb-4" data-aos="fade-up">
                    <i class="bi bi-geo-alt fs-1 text-warning mb-2"></i>
                    <h5>Geolocalización Opcional</h5>
                    <p>Encuentra personas cerca de ti con afinidades cósmicas.</p>
                </div>
                <div class="col-md-4 mb-4" data-aos="fade-left">
                    <i class="bi bi-phone fs-1 text-warning mb-2"></i>
                    <h5>PWA: App como una web</h5>
                    <p>Instálala y úsala como una aplicación nativa.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="py-4 mt-5 text-center">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} AstroMatch. Todos los derechos reservados.</p>
            <p class="mb-0"><small>Hecho con <i class="bi bi-heart-fill text-danger"></i> en el cosmos</small></p>
        </div>
    </footer>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>
