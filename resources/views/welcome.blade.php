<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HPP Consultoría Minera - Soluciones Integrales para Minería</title>
    <link rel="icon" type="image/png" href="{{ asset('img/hpp.png') }}">
    @vite('resources/css/welcome.css')
</head>

<body>
    <!-- Barra de navegación -->
    <header>
        <div class="container">
            <nav>
                <div class="logo">
                    <img src="{{ asset('img/hpp.png') }}" alt="Logo"
                        style="height:40px; vertical-align:middle; margin-right:10px;">
                    HPP <span>Consultoría Minera</span>
                </div>
                <ul class="nav-links">
                    <li><a href="#inicio">Inicio</a></li>
                    <li><a href="#servicios">Servicios</a></li>
                    <li><a href="#nosotros">Nosotros</a></li>
                    <li><a href="#proyectos">Proyectos</a></li>
                    <li><a href="{{ route('contacto') }}">Contacto</a></li>
                    <li><a href="/login" class="login-btn">Iniciar Sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="inicio">
        <div class="container">
            <div class="hero-content">
                <h1>Soluciones Integrales para la Industria Minera</h1>
                <p>Expertos en consultoría, exploración, explotación y gestión sostenible de recursos minerales.</p>
                <a href="{{ route('contacto') }}" class="cta-btn">Contáctenos</a>
            </div>
        </div>
    </section>

    <!-- Servicios -->
    <section class="services" id="servicios">
        <div class="container">
            <div class="section-title">
                <h2>Nuestros Servicios</h2>
                <p>Ofrecemos soluciones especializadas para cada etapa del proceso minero, con los más altos estándares
                    de calidad y seguridad.</p>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-img">
                        <img src="https://images.unsplash.com/photo-1581093450021-4a7360e9a9d9?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                            alt="Exploración Minera">
                    </div>
                    <div class="service-content">
                        <h3>Exploración Minera</h3>
                        <p>Servicios geológicos avanzados para identificación y evaluación de yacimientos minerales con
                            tecnología de punta.</p>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-img">
                        <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                            alt="Planificación Minera">
                    </div>
                    <div class="service-content">
                        <h3>Planificación Minera</h3>
                        <p>Diseño estratégico de operaciones mineras para maximizar la eficiencia y rentabilidad de sus
                            proyectos.</p>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-img">
                        <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80"
                            alt="Gestión Ambiental">
                    </div>
                    <div class="service-content">
                        <h3>Gestión Ambiental</h3>
                        <p>Soluciones sostenibles para minimizar el impacto ambiental y cumplir con todas las
                            regulaciones.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contacto">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>HPP CONSULTORÍA MINERA</h3>
                    <p>Líderes en consultoría minera con más de 20 años de experiencia en proyectos a nivel nacional e
                        internacional.</p>
                </div>
                <div class="footer-column">
                    <h3>Servicios</h3>
                    <ul>
                        <li><a href="#">Exploración Minera</a></li>
                        <li><a href="#">Planificación Minera</a></li>
                        <li><a href="#">Gestión Ambiental</a></li>
                        <li><a href="#">Seguridad Industrial</a></li>
                        <li><a href="#">Optimización de Procesos</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Contacto</h3>
                    <ul>
                        <li>Av. Minera 123, Huaraz, Perú</li>
                        <li>info@hpp.com</li>
                        <li>+51 923 456 789</li>
                        <li><a href="{{ route('contacto') }}"
                                style="color: #fff; text-decoration: none; background: #2a5298; padding: 8px 15px; border-radius: 5px; display: inline-block; margin-top: 10px;">📝
                                Solicitar Cita</a></li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 HPP Consultoría Minera. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</body>

</html>
