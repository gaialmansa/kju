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
        /* --- Estilos para el botón de recarga manual --- */
        .manual-reload-button {
            display: block; /* Para que ocupe su propia línea */
            width: 100%; /* Que ocupe el ancho del contenedor */
            padding: 1rem;
            margin-top: 1.5rem; /* Espacio encima */
            background-color: #f0f0f0; /* Fondo gris claro */
            color: #333; /* Texto oscuro */
            border: 1px solid #ccc; /* Borde suave */
            border-radius: 10px;
            cursor: pointer;
            font-size: 1rem;
            text-align: center;
            transition: background-color 0.3s ease;
            max-width: 600px; /* Opcional: para que no sea más ancho que el contenedor principal */
            box-sizing: border-box; /* Incluir padding y borde en el ancho */
            text-decoration: none; /* Si usas un <a> */
        }

        .manual-reload-button:hover {
            background-color: #ddd; /* Fondo un poco más oscuro al pasar el ratón */
        }
        /* --------------------------------------------- */

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

        @media (max-width: 768px) {
            .question-text {
                font-size: 1.3rem;
            }
            
            .container {
                width: 100%;
                padding: 10px;
            }
            
            .question-card {
                padding: 1rem;
            }
            /* Ajustar el ancho del botón de recarga en pantallas pequeñas */
            .manual-reload-button {
                 /* Ajustar si el container tiene padding */
                width: calc(100% - 0px); /* Si el contenedor tiene padding, el 100% ya lo respeta */
                margin-left: auto;
                margin-right: auto;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<script>
       $(document).ready(function() {
           console.log('DOM Ready. Inicializando scripts para la vista de espera.');

           // --- Lógica de Chequeo Automático por AJAX ---
           // Variable para almacenar el último valor conocido recibido del servidor
           let lastKnownValue = null;

           // URL a la que haremos la petición AJAX para chequear el estado
           const checkUrl = '<?=$rootUrl?>/accion/getp/<?=$id_ponencia?>';

           // Función para realizar la petición AJAX usando jQuery, comparar el valor y recargar si es necesario
           function checkValueAndReload()
           {
              $.ajax(
              {
                 url: checkUrl,
                 method: 'GET',
                 dataType: 'text', // Esperamos que la respuesta sea texto (el número)
                 success: function(newValue) {
                     // Este código se ejecuta si la petición fue exitosa (código 2xx)
                     // newValue es el texto de la respuesta (el número)

                     // Si es la primera vez que obtenemos un valor, simplemente lo almacenamos
                     if (lastKnownValue === null) {
                         lastKnownValue = newValue;
                         // console.log('Valor inicial getp:', lastKnownValue); // Descomenta para depurar
                     } else if (newValue !== lastKnownValue) {
                         // Si el nuevo valor es diferente al último conocido
                         console.log('Valor getp cambió de', lastKnownValue, 'a', newValue, '. Recargando...');
                         lastKnownValue = newValue;
                         window.location.reload(); // Recargamos la página completa
                     } else {
                         // El valor es el mismo, no hacemos nada
                         // console.log('El valor sigue siendo:', newValue); // Descomenta para depurar
                     }
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                     // Este código se ejecuta si la petición falló (código no 2xx o error de red)
                     console.error('Error AJAX checkValue:', textStatus, errorThrown, jqXHR.status);
                     // No recargamos automáticamente en caso de errores.
                 }
              });
           }

           // Intervalo de chequeo (en milisegundos).
           const checkInterval = 5000; // 5 segundos

           // Iniciar el intervalo (dentro de $(document).ready para seguridad)
           setInterval(checkValueAndReload, checkInterval);
           console.log('Intervalo de chequeo getp iniciado.');


           // --- Manejador del Botón de Recarga Manual ---
           // Aseguramos que el manejador de clic se adjunte DENTRO de $(document).ready
           $('#manualReloadBtn').on('click', function() {
              console.log('Recarga manual iniciada por el usuario.');
              window.location.reload(); // Forzar la recarga de la página completa
           });
           console.log('Manejador de clic para #manualReloadBtn adjuntado.');

       }); // Fin de $(document).ready
    </script>
    <div class="container">
        <img src="<?=$rootUrl?>res/img/pofenas.png" alt="Pofesoft" class="qrcode">
        
        <!-- Tarjeta de Pregunta -->
        <div class="question-card">
            <div class="question-text">
                Esperando a que se inicie el test...
            </div>
        </div>
        <button id="manualReloadBtn" class="manual-reload-button">
            Pulsa aquí si la página no se recarga automáticamente
        </button>
    </div>
</body>
</html>