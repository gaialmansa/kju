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
            max-width: 800px; /* Añadido max-width para mejor control en pantallas grandes */
            text-align: center;
            position: relative;
            padding: 20px; /* Añadido padding para no pegar el contenido a los bordes */
            box-sizing: border-box; /* Para incluir padding en el ancho */
        }

        .text {
            font-size: 5rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 2rem;
            word-break: break-word; /* Evita desbordamiento en palabras largas */
        }

        .qrcode {
            position: absolute;
            top: 0;
            left: 0;
            width: 100px;
            height: auto;
            z-index: 10; /* Asegurar que esté encima */
        }

        .boton {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: #FF69B4;
            color: white;
            text-decoration: none;
            border-radius: 20px;
            margin-top: 2rem;
            transition: background-color 0.3s ease, opacity 0.3s ease; /* Añadir transición para la opacidad */
            cursor: pointer; /* Asegurar cursor de clic */
            border: none; /* Por si se usara como button */
            font-size: 1rem; /* Definir tamaño de fuente */
        }

        .boton:hover {
            background-color: #FF9966;
        }

        /* --- Estilo para el botón deshabilitado temporalmente --- */
        .boton.disabled {
            pointer-events: none; /* Impide que el mouse o el tacto disparen eventos de clic */
            opacity: 0.5; /* Reduce la opacidad para dar feedback visual */
            cursor: default; /* Cambia el cursor a la flecha por defecto */
        }
        /* --------------------------------------------------- */


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
            cursor: default; /* Cursor por defecto ya que no son clicables en esta vista */
            transition: all 0.3s;
            text-align: left; /* Alinear texto a la izquierda */
        }

        .option:hover {
            background-color: #e9ecef;
            /* transform: translateY(-2px); /* Quitar si no son clicables */
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
            z-index: 10; /* Asegurar que esté encima */
        }

        #totalVotes {
            font-weight: bold;
            color: #FF69B4;
        }

        /* Media queries para responsividad */
        @media (max-width: 768px) {
            .text {
                font-size: 3rem;
            }
            .qrcode {
                width: 80px;
            }
            .vote-counter {
                font-size: 1rem;
                padding: 0.3rem 0.6rem;
                top: 10px;
                right: 10px;
            }
             .question-panel {
                padding: 1.5rem;
            }
            .question {
                font-size: 1.3rem;
            }
            .options {
                grid-template-columns: 1fr; /* Opciones en una columna en pantallas pequeñas */
            }
            .option {
                padding: 0.8rem;
            }
            .boton {
                padding: 0.4rem 0.8rem;
            }
        }

         @media (max-width: 480px) {
             .text {
                font-size: 2rem;
            }
             .qrcode {
                width: 60px;
            }
            .vote-counter {
                font-size: 0.9rem;
                padding: 0.2rem 0.5rem;
                 top: 5px;
                right: 5px;
            }
             .question-panel {
                padding: 1rem;
            }
            .question {
                font-size: 1.1rem;
            }
             .option {
                font-size: 0.9rem;
            }
             .boton {
                font-size: 0.9rem;
            }
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
                        // Asegurarse de que las opciones no sean clicables en esta vista si solo muestran resultados
                        echo "  <div class='option'>$f.- {$opcion['opTexto']}</div>"; // Texto de la opción
                        $f++;
                     }
                ?>

            </div>
        </div>

        <a href="<?=$rootUrl?>accion/quiz/<?=$id_ponencia?>/next" class="boton">Siguiente</a>

    </div>

    <script>
        // --- Lógica para actualizar el contador de votos ---
        function updateVoteCount() {
            // URL para obtener el conteo de votos de la pregunta actual
            const voteCountUrl = '<?=$rootUrl?>accion/votos/<?=$pregunta->id_pregunta?>';

            fetch(voteCountUrl)
                .then(response => {
                    if (!response.ok) {
                        console.error('Error al obtener el conteo de votos:', response.statusText);
                        // Podemos retornar un error o un objeto vacío para evitar romper el siguiente .then
                        return Promise.reject('Respuesta de red no fue ok.');
                    }
                    return response.json();
                })
                .then(data => {
                    // Asumimos que la estructura de datos es { total: { count: N } }
                    if (data && data.total && typeof data.total.count !== 'undefined') {
                         document.getElementById('totalVotes').textContent = data.total.count;
                    } else {
                         console.warn('Estructura de datos inesperada para el conteo de votos:', data);
                         // Opcional: document.getElementById('totalVotes').textContent = 'Error';
                    }
                })
                .catch(error => {
                     console.error('Error al actualizar el conteo de votos:', error);
                     // Opcional: document.getElementById('totalVotes').textContent = 'Error';
                });
        }

        // Actualizar el conteo de votos cada 1 segundo
        setInterval(updateVoteCount, 1000);

        // Ejecutar la primera actualización inmediatamente al cargar la página
        updateVoteCount();


        // --- Lógica para deshabilitar el botón 'Siguiente' temporalmente ---
        const nextButton = document.querySelector('.boton'); // Obtener el botón por su clase
        const delayTime = 5000; // 5 segundos en milisegundos

        // Verificamos que el botón exista antes de intentar manipularlo
        if (nextButton) {
            // 1. Deshabilitar inmediatamente el botón visual y funcionalmente
            nextButton.classList.add('disabled'); // Añadimos la clase CSS 'disabled'

            console.log('Boton Siguiente deshabilitado por', delayTime / 1000, 'segundos.');

            // 2. Configurar un temporizador para re-habilitar el botón después del retraso
            setTimeout(function() {
                nextButton.classList.remove('disabled'); // Quitamos la clase CSS 'disabled'
                console.log('Boton Siguiente habilitado.');
            }, delayTime);

        } else {
            console.error('Elemento con clase "boton" (para el botón Siguiente) no encontrado en el DOM.');
        }

    </script>
</body>
</html>