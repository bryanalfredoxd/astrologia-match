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
        :root {
            --primary-color: #8A2BE2;
            --secondary-color: #FF1493;
            --dark-color: #0f0524;
            --light-color: #f8f9fa;
            --accent-color: #F5C518;
            --gradient-start: #1A1A40;
            --gradient-end: #4B0082;
            --pwa-safe-area: env(safe-area-inset-top) env(safe-area-inset-right) env(safe-area-inset-bottom) env(safe-area-inset-left);
        }
        
        body {
            background-color: var(--dark-color);
            color: var(--light-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }
        
         /* Navbar */
         .navbar {
            background: rgba(15, 5, 36, 0.9) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(138, 43, 226, 0.3);
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: clamp(1.4rem, 4vw, 1.8rem);
            background: linear-gradient(45deg, var(--accent-color), var(--secondary-color));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-flex;
            align-items: center;
            padding: 8px 0;
        }
        
        /* Buttons */
        .btn-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(138, 43, 226, 0.4);
        }
        
        .btn-primary:hover {
            background: linear-gradient(45deg, var(--secondary-color), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(138, 43, 226, 0.6);
        }
        
        .btn-outline-light {
            border: 2px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        
        .btn-outline-light:hover {
            border-color: white;
            background: rgba(255, 255, 255, 0.1);
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));
            position: relative;
            overflow: hidden;
            padding: 100px 0;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path fill="rgba(255,255,255,0.03)" d="M0,0 L100,0 L100,100 L0,100 Z" /><circle cx="20" cy="20" r="3" fill="rgba(255,255,255,0.1)" /><circle cx="80" cy="20" r="2" fill="rgba(255,255,255,0.1)" /><circle cx="50" cy="50" r="4" fill="rgba(255,255,255,0.1)" /><circle cx="30" cy="70" r="3" fill="rgba(255,255,255,0.1)" /><circle cx="70" cy="80" r="2" fill="rgba(255,255,255,0.1)" /></svg>');
            background-size: cover;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .display-4 {
            font-weight: 800;
            margin-bottom: 20px;
            background: linear-gradient(45deg, white, #e0c3fc);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .lead {
            font-size: 1.5rem;
            opacity: 0.9;
            max-width: 700px;
            margin: 0 auto 30px;
        }
        
        /* Features */
        .features-section {
            padding: 80px 0;
            background-color: rgba(15, 5, 36, 0.7);
            position: relative;
        }
        
        .features-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path fill="rgba(138,43,226,0.03)" d="M0,0 L100,0 L100,100 L0,100 Z" /><polygon points="50,10 60,40 90,40 65,60 75,90 50,70 25,90 35,60 10,40 40,40" fill="rgba(255,255,255,0.05)" /></svg>');
            background-size: cover;
        }
        
        .section-title {
            position: relative;
            display: inline-block;
            margin-bottom: 50px;
            font-weight: 700;
            color: var(--accent-color);
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 3px;
        }
        
        .feature-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px 20px;
            height: 100%;
            transition: all 0.3s ease;
            border: 1px solid rgba(138, 43, 226, 0.2);
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(138, 43, 226, 0.2);
            border-color: rgba(138, 43, 226, 0.5);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 20px;
            background: linear-gradient(45deg, var(--accent-color), var(--secondary-color));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .feature-card h5 {
            font-weight: 600;
            margin-bottom: 15px;
            color: white;
        }
        
        .feature-card p {
            opacity: 0.8;
        }
        
        /* Footer */
        footer {
            background: linear-gradient(to right, #0a0418, #1a0936);
            padding: 40px 0 20px;
            position: relative;
        }
        
        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary-color), transparent);
        }
        
        footer p {
            margin-bottom: 10px;
        }
        
        .social-icons {
            margin: 20px 0;
        }
        
        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            margin: 0 10px;
            color: white;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .display-4 {
                font-size: 2.5rem;
            }
            
            .lead {
                font-size: 1.2rem;
            }
            
            .hero-section {
                padding: 80px 0;
            }
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-stars"></i> AstroMatch
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Cómo funciona</a>
                    </li>
                    <li class="nav-item d-none d-lg-block">
                        <div class="nav-link">|</div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Testimonios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contacto</a>
                    </li>
                    <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                        <a class="btn btn-outline-light" href="#">Iniciar sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section class="hero-section">
        <div class="container hero-content" data-aos="fade-up">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-4 fw-bold">Conecta con tu alma gemela... ¡Astrológicamente!</h1>
                    <p class="lead">Descubre conexiones profundas basadas en tu carta astral. La química cósmica nunca antes fue tan precisa.</p>
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-star-fill me-2"></i> Comienza tu viaje
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FEATURES -->
    <section class="features-section">
        <div class="container">
            <h2 class="section-title text-center" data-aos="zoom-in">¿Qué te ofrece AstroMatch?</h2>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card text-center">
                        <i class="bi bi-moon-stars feature-icon"></i>
                        <h5>Emparejamiento Astrológico</h5>
                        <p>Basado en signos solares, lunares, ascendentes y compatibilidad de cartas natales completas para una conexión profunda.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card text-center">
                        <i class="bi bi-geo-alt feature-icon"></i>
                        <h5>Geolocalización Inteligente</h5>
                        <p>Encuentra personas cerca de ti con afinidades cósmicas. Configura el radio de búsqueda a tu preferencia.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card text-center">
                        <i class="bi bi-phone feature-icon"></i>
                        <h5>Experiencia PWA</h5>
                        <p>Instálala en tu dispositivo y disfruta de una aplicación nativa con notificaciones y acceso offline.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="feature-card text-center">
                        <i class="bi bi-gem feature-icon"></i>
                        <h5>Perfil Astrológico</h5>
                        <p>Crea un perfil detallado con tus posiciones planetarias y descubre cómo influyen en tus relaciones.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card text-center">
                        <i class="bi bi-chat-heart feature-icon"></i>
                        <h5>Chat Cósmico</h5>
                        <p>Conversa con tus matches en un ambiente diseñado para conexiones significativas.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card text-center">
                        <i class="bi bi-graph-up feature-icon"></i>
                        <h5>Reportes de Compatibilidad</h5>
                        <p>Recibe análisis detallados de tus conexiones con otros usuarios basados en astrología.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS -->
    <section class="py-5" style="background: linear-gradient(to bottom, #1a0936, #0a0418);">
        <div class="container py-5">
            <h2 class="section-title text-center mb-5" data-aos="zoom-in">Historias de amor cósmico</h2>
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="row g-4">
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="feature-card h-100">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="https://randomuser.me/api/portraits/women/32.jpg" class="rounded-circle me-3" width="60" height="60" alt="Usuario">
                                    <div>
                                        <h6 class="mb-0">María G.</h6>
                                        <small class="text-muted">Sol en Libra, Luna en Piscis</small>
                                    </div>
                                </div>
                                <p>"AstroMatch nos unió cuando menos lo esperábamos. Nuestras cartas natales mostraban una compatibilidad del 92% y ahora llevamos 1 año juntos."</p>
                                <div class="text-warning">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="feature-card h-100">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="https://randomuser.me/api/portraits/men/45.jpg" class="rounded-circle me-3" width="60" height="60" alt="Usuario">
                                    <div>
                                        <h6 class="mb-0">Carlos R.</h6>
                                        <small class="text-muted">Sol en Acuario, Luna en Aries</small>
                                    </div>
                                </div>
                                <p>"Nunca creí en la astrología hasta que conocí a mi pareja aquí. La forma en que nuestros elementos se complementan es asombrosa."</p>
                                <div class="text-warning">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="feature-card h-100">
                                <div class="d-flex align-items-center mb-3">
                                    <img src="https://randomuser.me/api/portraits/women/68.jpg" class="rounded-circle me-3" width="60" height="60" alt="Usuario">
                                    <div>
                                        <h6 class="mb-0">Lucía M.</h6>
                                        <small class="text-muted">Sol en Cáncer, Luna en Tauro</small>
                                    </div>
                                </div>
                                <p>"Después de años en apps convencionales, AstroMatch fue un respiro. Finalmente encuentro personas que entienden mi energía."</p>
                                <div class="text-warning">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA SECTION -->
    <section class="py-5" style="background: linear-gradient(135deg, var(--gradient-start), var(--gradient-end));">
        <div class="container py-4">
            <div class="row align-items-center">
                <div class="col-lg-8 mb-4 mb-lg-0" data-aos="fade-right">
                    <h3 class="fw-bold mb-3">¿Listo para encontrar tu conexión cósmica?</h3>
                    <p class="mb-0">Regístrate ahora y recibe un análisis gratuito de tu carta natal para entender mejor lo que buscas en una relación.</p>
                </div>
                <div class="col-lg-4 text-lg-end" data-aos="fade-left">
                    <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-lg px-4 py-3">
                        <i class="bi bi-arrow-right-circle me-2"></i> Comenzar ahora
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <h5 class="mb-4"><i class="bi bi-stars me-2"></i> AstroMatch</h5>
                    <p>La plataforma líder en emparejamiento astrológico. Conectando almas afines desde 2023.</p>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-4">Enlaces</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-light">Inicio</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-light">Cómo funciona</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-light">Precios</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-light">Blog</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-4">Legal</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-decoration-none text-light">Términos</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-light">Privacidad</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-light">Cookies</a></li>
                        <li class="mb-2"><a href="#" class="text-decoration-none text-light">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-lg-4 col-md-4">
                    <h5 class="mb-4">Contacto</h5>
                    <p><i class="bi bi-envelope me-2"></i> hola@astromatch.com</p>
                    <div class="social-icons">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4 bg-secondary opacity-10">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; {{ date('Y') }} AstroMatch. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="mb-0"><small>Hecho con <i class="bi bi-heart-fill text-danger"></i> en el cosmos</small></p>
                </div>
            </div>
        </div>
    </footer>

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
        
        // Cambiar navbar al hacer scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 4px 20px rgba(138, 43, 226, 0.2)';
                navbar.style.padding = '10px 0';
            } else {
                navbar.style.boxShadow = 'none';
                navbar.style.padding = '15px 0';
            }
        });
    </script>
</body>
</html>