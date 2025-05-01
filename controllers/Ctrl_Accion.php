<?php



use zfx\View;
class Ctrl_Accion extends \zfx\Controller 
{

        public $db, $retorno;
        public function _main()
         {
                $res = $this->_autoexec();
                if (!$res) 
                        $this->seleccionar();
         }
        public function getp($id_ponencia)    // obtiene el id de la pregunta en curso
        {
            $Ponencia = New Ponencia($id_ponencia);
            header('Content-Type: text/plain'); // Opcional, pero mejora la claridad
            echo $Ponencia->getPreguntaActivaId();
        }


        public function seleccionar() // Selecciona la ponencia
            {
            $data = array();
            $data['rootUrl'] = \zfx\Config::get('rootUrl');
            //$data['user'] = $this->_getUser(); // Obtenemos el usuario
            $data['user'] = 3;
            $data['ponencias'] = Ponencia::getAll(); // Obtenemos todas las ponencias del usuario activo
            //die(var_dump($data));
            $this->_view = new View("listaPonencias", $data);
            //$this->_view->addSection('head', 'head');
            $this->_view->show();
            }  
        public function quiz($id_ponencia,$next = NULL) // Comienza el quiz
            {
            $rootUrl = \zfx\Config::get('rootUrl');     // Establecemos la URL de la app
            $Ponencia = New Ponencia($id_ponencia);     // Instanciamos el quiz
            $this->genQR($id_ponencia); // generamos el QR que se queda grabado en la carpeta res/QR
            $data = array();
            $data['rootUrl'] = $rootUrl;
            $data['id_ponencia'] = $id_ponencia;
            if(is_null($next))      // cuando es nulo, estamos a punto de empezar el test
            {
                $Ponencia->clear(true); // Borramos el flag de activa a todas las preguntas del quiz
                $Ponencia->unsetTerminada(); // Borramos el flag de terminada a la ponencia
                $this->_view = new View("testQR", $data);   // Pantalla de inicio (QR grandote)
                //$this->_view->addSection('head', 'head');
                $this->_view->show();
            }
            else
            {   
                $data['pregunta'] = $Ponencia->getNext(); // Obtenemos la siguiente pregunta. A la vez, cambia la pregunta activa
                if(is_null($data['pregunta'])) // no quedan más preguntas
                    $this->resultados($id_ponencia); // mostramos los resultados
                else
                    {
                    $this->_view = New View("test", $data);   // Pantalla de preguntas
                    $this->_view->show();
                    }
                //$this->_view->addSection('head', 'head');
            }
            
            }
        public function votos($id_pregunta) // Obtenemos el número de votos
            {
                $data['total'] = Ponencia::getVotos($id_pregunta); // Obtenemos el número de votos
                echo json_encode($data);
            }
        public function resultados($id_ponencia, $client = false) // mostramos los resultados
            {
                $rootUrl = \zfx\Config::get('rootUrl');     // Establecemos la URL de la app
                $Ponencia = New Ponencia($id_ponencia);     // Instanciamos el quiz
                $data = array();
                $data['rootUrl'] = $rootUrl;
                $data['preguntas'] = $Ponencia->resultados($id_ponencia); // Obtenemos los resultados
                $data['id_ponencia'] = $id_ponencia;
                $data['client'] = $client;
                //die(var_dump($data));
                $this->_view = New View("Resultados", $data);   // Pantalla de resultados
                $this->_view->show();
            }
        private function genQR($id_ponencia)
                {
                $rootUrl = \zfx\Config::get('rootUrl');
                unlink('res/QR/test-qr.png');
                shell_exec("qrencode -s 5 -o res/QR/test-qr.png {$rootUrl}accion/quizx/{$id_ponencia}/");
                return;
                }
        public function quizx($id_ponencia,$next = NULL) // Comienza el quiz
            {
            $rootUrl = \zfx\Config::get('rootUrl');     // Establecemos la URL de la app
            $Ponencia = New Ponencia($id_ponencia);     // Instanciamos el quiz
            $data = array();
            $data['rootUrl'] = $rootUrl;
            $data['id_ponencia'] = $id_ponencia;
            if($Ponencia->ponencia->terminada == 't') // si la ponencia ya ha terminado, no hacemos nada
                {
                $this->resultados($id_ponencia,true); // mostramos los resultados con el flag de movil para que no saque el boton de abajo
                return;
                }
            $data['pregunta'] = $Ponencia->getPreguntaActivaConOpciones($this->getIP()); // Obtenemos la siguiente pregunta. A la vez, cambia la pregunta activa
            //die(var_dump($data));
            if(is_null($data['pregunta'])) // aun no hay una pregunta activada
                {
                $this->_view = new View("Esperando", $data);   
                $this->_view->show();
                }
            else
                {
                //echo var_dump($data);
                $this->_view = new View("Contestar", $data);   
                $this->_view->show();
                }


            }
        public function contestar() // Comienza el quiz
            {
                $id_pregunta = $_POST['id_pregunta'];
                $id_opcion = $_POST['id_opcion'];
                $ip = $this->getIP();
                if($ip == 'IP desconocida') // si hay error con la IP, no hacemos nada
                    return;
                Ponencia::grabarRespuesta($id_pregunta,$id_opcion,$ip); // Registramos la respuesta
                
            }
        private function getIP()
            {
             session_start();

                return session_id();
            }




}
