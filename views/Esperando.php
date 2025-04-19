<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta Interactiva</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(to bottom right, #FF69B4, #F5DEB7, #90EE90, #00C853);
            font-family: Arial, sans-serif;
        }

        .container {
            width: 95%;
            max-width: 600px;
            text-align: center;
            padding: 20px;
        }

        .question-card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .question-text {
            font-size: 1.5rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 1.5rem;
        }

        .options-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .option-button {
            display: block;
            padding: 1rem;
            background-color: #FF69B4;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-size: 1.1rem;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            text-align: center;
        }

        .option-button:hover {
            background-color: #FF9966;
            transform: scale(1.02);
        }

        .qrcode {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 80px;
            height: auto;
        }

        @media (max-width: 768px) {
            .question-text {
                font-size: 1.3rem;
            }
            
            .option-button {
                padding: 0.8rem;
                font-size: 1rem;
            }
            
            .qrcode {
                width: 60px;
            }
        }

        @media (max-width: 480px) {
            .question-text {
                font-size: 1.2rem;
            }
            
            .container {
                width: 100%;
                padding: 10px;
            }
            
            .question-card {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
<script>
    setInterval(function() {
        window.location.reload();
    }, 1000); // 1000 ms = 1 segundo
</script>
    <div class="container">
        <img src="<?=$rootUrl?>res/img/pofenas.png" alt="Pofesoft" class="qrcode">
        
        <!-- Tarjeta de Pregunta -->
        <div class="question-card">
            <div class="question-text">
                Esperando a que se inicie el test...
            </div>
            
            <!-- Grid de Opciones 
            <div class="options-grid">
                 Cada opción es un enlace a tu entry point con parámetro 
                <a href="/entry-point?respuesta=1&pregunta=123" class="option-button">Python</a>
                <a href="/entry-point?respuesta=2&pregunta=123" class="option-button">JavaScript</a>
                <a href="/entry-point?respuesta=3&pregunta=123" class="option-button">Java</a>
                <a href="/entry-point?respuesta=4&pregunta=123" class="option-button">PHP</a>
            </div>
            -->
        </div>
    </div>
</body>
</html>