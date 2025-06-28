<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HPP Consultoría Minera - Soluciones Integrales para Minería</title>
    <link rel="icon" type="image/png" href="{{ asset('img/hpp.png') }}">
    <style>
        /* Estilos generales */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* Barra de navegación */
        header {
            background-color: #1a3e72;
            color: white;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: #ffd700;
        }
        
        .logo span {
            color: white;
        }
        
        .nav-links {
            display: flex;
            list-style: none;
        }
        
        .nav-links li {
            margin-left: 2rem;
            position: relative;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .nav-links a:hover {
            color: #ffd700;
        }
        
        .login-btn {
            background-color: #ffd700;
            color: #1a3e72;
            padding: 0.5rem 1.2rem;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .login-btn:hover {
            background-color: #e6c200;
            color: #1a3e72;
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('https://images.unsplash.com/photo-1581093196277-1c6dd0a1f3e1?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            height: 80vh;
            display: flex;
            align-items: center;
            text-align: center;
            color: white;
        }
        
        .hero-content {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .hero h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
        }
        
        .cta-btn {
            background-color: #ffd700;
            color: #1a3e72;
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .cta-btn:hover {
            background-color: #e6c200;
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        /* Servicios */
        .services {
            padding: 5rem 0;
            background-color: white;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            color: #1a3e72;
            margin-bottom: 1rem;
        }
        
        .section-title p {
            color: #666;
            max-width: 700px;
            margin: 0 auto;
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .service-card {
            background-color: #f9f9f9;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
        }
        
        .service-img {
            height: 200px;
            overflow: hidden;
        }
        
        .service-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .service-card:hover .service-img img {
            transform: scale(1.1);
        }
        
        .service-content {
            padding: 1.5rem;
        }
        
        .service-content h3 {
            color: #1a3e72;
            margin-bottom: 1rem;
        }
        
        /* Footer */
        footer {
            background-color: #1a3e72;
            color: white;
            padding: 3rem 0 1rem;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .footer-column h3 {
            color: #ffd700;
            margin-bottom: 1.5rem;
            font-size: 1.2rem;
        }
        
        .footer-column ul {
            list-style: none;
        }
        
        .footer-column ul li {
            margin-bottom: 0.8rem;
        }
        
        .footer-column ul li a {
            color: #ddd;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-column ul li a:hover {
            color: #ffd700;
        }
        
        .copyright {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #aaa;
            font-size: 0.9rem;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }
            
            .hero h1 {
                font-size: 2.2rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Barra de navegación -->
    <header>
        <div class="container">
            <nav>
                <div class="logo">
                    <img src="{{ asset('img/hpp.png') }}" alt="Logo" style="height:40px; vertical-align:middle; margin-right:10px;">
                    HPP <span>Consultoría Minera</span>
                </div>
                <ul class="nav-links">
                    <li><a href="#inicio">Inicio</a></li>
                    <li><a href="#servicios">Servicios</a></li>
                    <li><a href="#nosotros">Nosotros</a></li>
                    <li><a href="#proyectos">Proyectos</a></li>
                    <li><a href="#contacto">Contacto</a></li>
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
                <a href="#contacto" class="cta-btn">Contáctenos</a>
            </div>
        </div>
    </section>

    <!-- Servicios -->
    <section class="services" id="servicios">
        <div class="container">
            <div class="section-title">
                <h2>Nuestros Servicios</h2>
                <p>Ofrecemos soluciones especializadas para cada etapa del proceso minero, con los más altos estándares de calidad y seguridad.</p>
            </div>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-img">
                        <img src="https://images.unsplash.com/photo-1581093450021-4a7360e9a9d9?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Exploración Minera">
                    </div>
                    <div class="service-content">
                        <h3>Exploración Minera</h3>
                        <p>Servicios geológicos avanzados para identificación y evaluación de yacimientos minerales con tecnología de punta.</p>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-img">
                        <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Planificación Minera">
                    </div>
                    <div class="service-content">
                        <h3>Planificación Minera</h3>
                        <p>Diseño estratégico de operaciones mineras para maximizar la eficiencia y rentabilidad de sus proyectos.</p>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-img">
                        <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Gestión Ambiental">
                    </div>
                    <div class="service-content">
                        <h3>Gestión Ambiental</h3>
                        <p>Soluciones sostenibles para minimizar el impacto ambiental y cumplir con todas las regulaciones.</p>
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
                    <h3>MINERACONSULT</h3>
                    <p>Líderes en consultoría minera con más de 20 años de experiencia en proyectos a nivel nacional e internacional.</p>
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
                        <li>info@mineraconsult.com</li>
                        <li>+51 923 456 789</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2023 MineraConsult. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>
</body>
</html>