<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historia, Misión y Visión</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
            color: #333;
        }

        header {
            background-color: #004080;
            color: white;
            padding: 2rem;
            text-align: center;
        }

        main {
            max-width: 900px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        section {
            margin-bottom: 2.5rem;
        }

        h2 {
            color: #004080;
            margin-bottom: 0.5rem;
        }

        p {
            line-height: 1.6;
        }

        .btn-home {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background-color: #004080;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-home:hover {
            background-color: #0066cc;
        }

        .btn-container {
            text-align: center;
            margin-top: 2rem;
        }

        footer {
            text-align: center;
            padding: 1rem;
            background-color: #004080;
            color: white;
        }
    </style>
</head>
<body>

    <header>
        <h1>Historia, Misión y Visión</h1>
    </header>

    <main>
        <section>
            <h2>Historia</h2>
            <p>
                Nuestra empresa fue fundada en el año 2010 con el objetivo de brindar soluciones especializadas al sector minero del Perú. A lo largo de los años, hemos trabajado junto a diversas compañías líderes en la industria, ofreciendo asesoría técnica, estudios especializados y acompañamiento estratégico. Gracias a nuestro compromiso con la calidad y la innovación, nos hemos consolidado como una consultora de confianza, contribuyendo al desarrollo sostenible y al fortalecimiento de la minería responsable.
            </p>
        </section>

        <section>
            <h2>Misión</h2>
            <p>
                Brindar soluciones integrales y asesoría técnica especializada para el sector minero, contribuyendo al desarrollo sostenible y la excelencia operativa de nuestros clientes.
            </p>
        </section>

        <section>
            <h2>Visión</h2>
            <p>
                Ser la consultora minera líder en Perú, reconocida por la innovación, calidad y compromiso con el crecimiento responsable del sector minero.
            </p>
        </section>

        <div class="btn-container">
            <a href="{{ url('/home') }}" class="btn-home">Volver al Inicio</a>
        </div>
    </main>

    <footer>
        &copy; 2025 Consultora Minera S.A.C. - Todos los derechos reservados
    </footer>

</body>
</html>
