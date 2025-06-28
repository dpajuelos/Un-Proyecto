<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organigrama</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #2A5CAA;
        }
        .organigrama {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .node {
            border: 1px solid #2A5CAA;
            border-radius: 8px;
            padding: 10px;
            margin: 10px;
            text-align: center;
            width: 150px;
            background-color: #F8F9FA;
        }
        .line {
            width: 2px;
            background-color: #2A5CAA;
            height: 20px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <h1>Organigrama de la Empresa</h1>
    <div class="organigrama">
        <div class="node">
            <h2>Director General</h2>
        </div>
        <div class="line"></div>
        <div class="node">
            <h2>Gerente de Operaciones</h2>
        </div>
        <div class="line"></div>
        <div class="node">
            <h2>Gerente de Finanzas</h2>
        </div>
        <div class="line"></div>
        <div class="node">
            <h2>Gerente de Recursos Humanos</h2>
        </div>
        <div class="line"></div>
        <div class="node">
            <h2>Gerente de Marketing</h2>
        </div>
    </div>
</body>
</html>