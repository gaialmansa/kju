<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            max-width: 1200px;
            text-align: center;
            position: relative;
            padding: 20px;
        }

        .text {
            font-size: 2rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 1.5rem;
        }

        .qrcode {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 80px;
            height: auto;
        }

        .boton {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            background-color: #FF69B4;
            color: white;
            text-decoration: none;
            border-radius: 20px;
            margin-top: 2rem;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .boton:hover {
            background-color: #FF9966;
            transform: scale(1.05);
        }

        .results-panel {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 15px;
            padding: 1.5rem;
            margin: 2rem 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .question-block {
            margin-bottom: 2rem;
            text-align: left;
            border-bottom: 2px solid #FF69B4;
            padding-bottom: 1rem;
        }

        .question-text {
            font-size: 1.3rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 1rem;
        }

        .options-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .option-card {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .option-text {
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .correct-answer {
            background-color: rgba(144, 238, 144, 0.5);
            border-left: 4px solid #00C853;
        }

        .stats {
            margin-top: 0.8rem;
            font-size: 0.9rem;
        }

        .votes {
            color: #FF69B4;
            font-weight: bold;
        }

        .percentage {
            color: #2c3e50;
            font-weight: bold;
        }

        .percentage-bar {
            height: 20px;
            background-color: #f1f1f1;
            border-radius: 10px;
            margin-top: 8px;
            overflow: hidden;
        }

        .percentage-bar-fill {
            height: 100%;
            background-color: #00C853;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 5px;
            color: white;
            font-size: 0.7rem;
            min-width: 20px;
        }

        @media (max-width: 768px) {
            .text {
                font-size: 1.8rem;
                margin-top: 40px;
            }
            
            .qrcode {
                width: 60px;
            }
            
            .options-grid {
                grid-template-columns: 1fr;
            }
            
            .question-text {
                font-size: 1.1rem;
            }
            
            .boton {
                padding: 0.7rem 1.3rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 480px) {
            .text {
                font-size: 1.5rem;
            }
            
            .container {
                width: 100%;
                padding: 10px;
            }
            
            .results-panel {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="text">Resultados del Test</div>
        
        <div class="results-panel">
             <?php
             foreach ($preguntas as $pregunta)
             {?>
             <!-- Pregunta <?=$pregunta['texto']?> -->
             <div class="question-block">
                <div class="question-text"><?=$pregunta['texto']?></div>
                <div class="options-grid">
                <?php
                foreach ($pregunta['opciones'] as $opcion)
                    {
                        if($opcion['correcta']<>'t')  // No es correcta
                        {
                            ?>
            
                    <div class="option-card">
                        
                    <?php
                        }
                        else // Es correcta
                        {
                            ?>
                    <div class="option-card correct-answer">
                        <?php
                            }?>
                        <div class="option-text"><?=$opcion['opTexto']?></div>
                        <div class="stats">
                                <span class="votes"><?=$opcion['votos']?> votos</span> | 
                                <span class="percentage"><?=$opcion['pc']?>%</span>
                        </div>
                            <div class="percentage-bar">
                                <div class="percentage-bar-fill" style="width: <?=$opcion['pc']?>%"><?=$opcion['pc']?>%</div>
                            </div>
                    </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <?php                    
                }?>
           
        </div>
        <?php 
        if(!$client)
        {?>
            <a target="_blank" href="<?=$rootUrl?>accion/" class="boton">Nuevo Test</a>
        <?php
        }?>        
    </div>
</body>
</html>