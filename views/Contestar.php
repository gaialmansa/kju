<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PofEncuesta Interactiva</title>
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
        .option-btn {
            display: block;
            padding: 1rem;
            background-color: #FF69B4;
            color: white;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
            text-align: left;
            border: none;
            font-size: 1.1rem;
        }

        .option-btn:hover {
            background-color: #FF9966;
            transform: scale(1.02);
        }
        .option-btn {
            position: relative;
            transition: all 0.3s ease;
        }
         /* Estado "enviado-vista inmediata" */
         .option-btn.sent {
            background-color: rgba(144, 238, 144, 0.7) !important; /* Verde claro */
            border-left: 4px solid #00C853 !important;
            color: #2c3e50;
        }

        /* Estado "enviado" */
        .option-btnsent {
            background-color: rgba(144, 238, 144, 0.7) !important; /* Verde claro */
            border-left: 4px solid #00C853 !important;
            color: #2c3e50;
        }

        .checkmark {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: #00C853;
            font-weight: bold;
            opacity: 0;
            transition: opacity 0.3s;
            font-size: 1.2rem;
        }
        .checkmarksent {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            color: #00C853;
            font-weight: bold;
            opacity: 1;
            transition: opacity 0.3s;
            font-size: 1.2rem;
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
                <?=$pregunta->texto?>
            </div>
            
            <!-- Grid de Opciones -->
            <div class="options-grid">
                <!-- Cada opción es un enlace a tu entry point con parámetro -->
                 <?php
                foreach($pregunta->opciones as $opcion)
                {
                    ?>
                    <div class="option-btn<?=$opcion['checked']?>" data-option="<?=$opcion['id_opcion']?>" data-pregunta="<?=$opcion['id_pregunta']?>">
                    <div class="option-text"><?=$opcion['opTexto']?></div>
                    
                </div>
                    <!--<a href="/entry-point?respuesta=<?=$opcion->id_opcion?>&pregunta=<?=$pregunta->id_pregunta?>" class="option-button"><?=$opcion['opTexto']?></a>-->
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
       $('.option-btn').on('click touchstart', function(e) {
            e.preventDefault();
            const optionBtn = $(this);
            
            if (optionBtn.hasClass('sent')) return;
            
            // Feedback visual inmediato
            $('.option-btn').removeClass('sent');
            optionBtn.addClass('sent');
            
            // Datos para el AJAX
            const optionId = optionBtn.data('option');
            const questionId = optionBtn.data('pregunta');
            
            $.ajax({
                url: '<?=$rootUrl?>accion/contestar',
                method: 'POST',
                dataType: 'json', // Asegúrate de que el servidor devuelva JSON
                data: {
                    id_pregunta: questionId,
                    id_opcion: optionId
                }
            });
        });
</script>
</body>
</html>