<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(to bottom right, #FF69B4, #F5DEB7, #90EE90, #00C853);
        }

        .container {
            width: 80%;
            text-align: center;
        }

        .text {
            font-size: 5rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 2rem;
        }

        .qrcode {
            flex: 1;
            padding: 2rem;
            text-align: center;
        }
        .boton {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #FF69B4; /* Color orangeo del gradiente */
            color: white;
            text-decoration: none;
            border-radius: 20px;
            margin-left: auto; /* Centra el botón horizontalmente */
        }

        .boton:hover {
            background-color: #FF9966; /* Gris oscuro del orange */
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="text">Comenzamos</div>
        <img src="<?=$rootUrl?>res/QR/test-qr.png" alt="QR Code" class="qrcode">
        <a href="<?=$rootUrl?>accion/quiz/<?=$id_ponencia?>/next" class="boton">Siguiente</a> <!-- Enlace de ejemplo a disney.com -->

    </div>
</body>
</html>

    
