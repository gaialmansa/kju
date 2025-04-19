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
            font-family: Arial, sans-serif;
        }

        .container {
            width: 80%;
            text-align: center;
            position: relative;
        }

        .text {
            font-size: 5rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 2rem;
        }

        .qrcode {
            position: absolute;
            top: 0;
            left: 0;
            width: 100px;
            height: auto;
        }

        .boton {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #FF69B4;
            color: white;
            text-decoration: none;
            border-radius: 20px;
            margin-top: 2rem;
        }

        .boton:hover {
            background-color: #FF9966;
        }

        .question-panel {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            padding: 2rem;
            margin: 2rem 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .question {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: #2c3e50;
        }

        .options {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .option {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 1rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .option:hover {
            background-color: #e9ecef;
            transform: translateY(-2px);
        }
        .vote-counter {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 1.2rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        #totalVotes {
            font-weight: bold;
            color: #FF69B4;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="<?=$rootUrl?>res/QR/test-qr.png" alt="QR Code" class="qrcode">
        <div class="vote-counter">
        <span id="totalVotes">0</span> votos recibidos
    </div>
        <div class="text">Pregunta</div>
        
        <div class="question-panel">
            <div class="question"><?=$pregunta->texto?></div>
            <div class="options">
                <?php
                $f = 1;
                foreach ($pregunta->opciones as $opcion)
                     {
                        echo "  <div class='option'>$f.-{$opcion['opTexto']}</div>";
                        $f++;
                     }
                ?>
                
            </div>
        </div>
        
        <a href="<?=$rootUrl?>accion/quiz/<?=$id_ponencia?>/next" class="boton">Siguiente</a> <!-- Enlace de ejemplo a disney.com -->

    </div>
    <script>
        // Función para actualizar el contador de votos
        function updateVoteCount() {
            fetch('<?=$rootUrl?>accion/votos/<?=$pregunta->id_pregunta?>')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('totalVotes').textContent = data.total.count;
                })
                .catch(error => console.error('Error:', error));
        }

        // Actualizar cada segundo
        setInterval(updateVoteCount, 1000);

        // Ejecutar inmediatamente al cargar la página
        updateVoteCount();
</script>  
</body>
</html>