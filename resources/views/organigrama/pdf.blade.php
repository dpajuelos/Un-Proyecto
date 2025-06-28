<!DOCTYPE html>
<html>
<head>
    <title>Organigrama</title>
    <style>
        body { 
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .titulo { 
            text-align: center; 
            font-size: 24px; 
            margin-bottom: 20px;
            color: #333;
        }
        .organigrama-container {
            text-align: center;
            margin-top: 20px;
        }
        .organigrama-img { 
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="titulo">Organigrama de la Empresa</div>
    
    <div class="organigrama-container">
        <!-- Usa la ruta pública correcta -->
        <img src="{{ asset('img/organigrama.pdf') }}" alt="Organigrama de HPP" class="organigrama-img">
    </div>

    <!-- Mensaje alternativo si la imagen no carga -->
    <p style="text-align: center; color: #666; margin-top: 10px;">
        Si no puedes ver la imagen, por favor contacta al administrador.
    </p>
</body>
</html>