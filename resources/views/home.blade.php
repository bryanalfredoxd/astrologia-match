@extends('layouts.app')

@section('title', 'Encuentra tu conexión cósmica')

@section('content')
<picture>
    <source srcset="/images/fondo1-mobile.webp" type="image/webp" media="(max-width: 768px)">
</picture>
<!-- HERO SECTION -->
    <section class="hero-section">
        <div class="container hero-content" data-aos="fade-up">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-3 fw-bold">Conecta con tu alma gemela ¡Astrológicamente!</h1>
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

@endsection
