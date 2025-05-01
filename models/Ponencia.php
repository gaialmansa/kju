<?php

class  Ponencia
{
    public $db;
    public $id_ponencia;
    public $preguntas;
    public $ponencia;

    public function __construct($id_ponencia)   // constructor
        {
        $this->db = New \zfx\DB();
        $this->id_ponencia = $id_ponencia;
        $qry = "SELECT * FROM ponencias WHERE id_ponencia = $id_ponencia";
        $this->ponencia = $this->db->qobj($qry); // Obtenemos la ponencia
        }   
    static function getVotos($id_pregunta) // Obtenemos el número de votos de la pregunta
        {
        $db = new \zfx\DB();
        $qry = "
        SELECT COUNT(*) FROM respuestas
        WHERE id_pregunta = $id_pregunta
        ";
        return $db->qobj($qry); // Obtenemos el número de votos de la pregunta
        }
    public function getPreguntaActiva() // obtenemos la pregunta activa
        {
        $qry = "
        SELECT * FROM  preguntas
        WHERE id_ponencia = $this->id_ponencia
            AND abierto
        ";      
        return $this->db->qobj($qry); 
        }
    public function getPreguntaActivaId() // obtenemos la pregunta activa
        {
        $qry = "
        SELECT id FROM  preguntas
        WHERE id_ponencia = $this->id_ponencia
            AND abierto
        ";      
        return $this->db->qobj($qry)->id; 
        }
    public function getPreguntaActivaConOpciones($ip) // obtenemos la pregunta activa con sus opciones
        {
        $pregunta = $this->getPreguntaActiva(); // Obtenemos la pregunta activa
        if(is_null($pregunta))  // no hay pregunta activa. Devolvemos un Null
            return NULL;
        $pregunta->opciones = $this->getOpciones($pregunta->id_pregunta); // añadimos las opciones a la pregunta
        $userOption = $this->getRespuesta($ip,$pregunta->id_pregunta); // recuperamos la respuesta del usuario
        foreach($pregunta->opciones as &$opcion)
            {
                if($userOption == $opcion['id_opcion']) // si la opción es la respuesta del usuario
                    $opcion['checked'] = "sent"; // marcamos la opción como seleccionada
                else
                    $opcion['checked'] = ""; // desmarcamos la opción
            }
            return $pregunta; 
        }
    private function getRespuesta($ip, $id_pregunta)      // recuperamos la respuesta del usuario
        {
        $qry = "
        SELECT * FROM respuestas
        WHERE ip = '$ip'
            AND id_pregunta = $id_pregunta
            AND ip = '$ip'
        ";
        return $this->db->qobj($qry)->id_opcion; // Obtenemos la respuesta del usuario
        }
    public function clear($respuestas = false) // Borramos el flag de activa a todas las preguntas del quiz
        {
        $qry = "
        UPDATE preguntas
            SET abierto = FALSE
        WHERE id_ponencia = $this->id_ponencia
        ";
        $this->db->q($qry); // desactivamos todas las preguntas
        if($respuestas) // si es true, borramos las respuestas
            {
            $qry = "
            DELETE FROM respuestas
            USING preguntas
            WHERE respuestas.id_pregunta = preguntas.id_pregunta
                AND preguntas.id_ponencia = $this->id_ponencia
            ";
            $this->db->q($qry); // borramos todas las respuestas
            }
        }
    public function getNext() // Obtenemos la siguiente pregunta. A la vez, cambia la pregunta activa
        {
        // primero recuperamos la pregunta activa
        $activa = $this->getPreguntaActiva();
        if(is_null($activa))
            {
            $activa = $this->setFirst(); // Si no hay pregunta activa, la activamos
            if(is_null($activa))
                die("No hay preguntas en la ponencia");
            return $activa;
            }
        $qry = "
                SELECT * FROM ponencias
                    NATURAL JOIN preguntas
                WHERE ponencias.id_ponencia = $this->id_ponencia
                    AND preguntas.orden > $activa->orden
                ORDER BY preguntas.orden
                LIMIT 1
                ";
        $pregunta = $this->db->qobj($qry); // Obtenemos la siguiente pregunta
        if(is_null($pregunta))  // no quedan mas
            {
            $this->clear(); // desactivamos todas las preguntas
            $qry = "
            UPDATE ponencias
                SET terminada = TRUE
            WHERE id_ponencia = $this->id_ponencia
            ";
            $this->db->q($qry); // marcamos la ponencia como terminada
            return NULL; // No hay más preguntas
            }
        $this->setActiva($pregunta->id_pregunta); // activamos pregunta en curso    
        $pregunta->opciones = $this->getOpciones($pregunta->id_pregunta); // añadimos las opciones a la pregunta
        return $pregunta; // devolvemos la pregunta activa
        }
    private function getOpciones($id_pregunta)
        {
        $qry = "
        SELECT * FROM opciones
        WHERE id_pregunta = $id_pregunta
        ORDER BY id_opcion
        ";
        return $this->db->qa($qry); // Obtenemos las opciones de la pregunta
        }
    public function setActiva($id_pregunta) // activamos la pregunta en curso
        {
        $this->clear(); // desactivamos todas las preguntas
        $qry = "
        UPDATE preguntas
            SET abierto = TRUE
        WHERE id_pregunta = $id_pregunta
        ";

        $this->db->q($qry); // activamos la pregunta
        }
    public function unsetTerminada() // Eliminamos el flag de terminada para la ponencia actual
        {
            $qry = "
            UPDATE ponencias
                SET terminada = FALSE
            WHERE id_ponencia = $this->id_ponencia
                ";
            $this->db->q($qry); // marcamos la ponencia como no terminada
        }


    public function setFirst() // Activamos la primera pregunta
        {

        $qry = "
        SELECT * FROM ponencias
            NATURAL JOIN preguntas
        WHERE ponencias.id_ponencia = $this->id_ponencia
            ORDER BY orden
            LIMIT 1
        ";
        $pregunta = $this->db->qobj($qry); // Obtenemos la primera pregunta
        $this->unsetTerminada(); // desactivamos el flag de terminada
        $this->setActiva($pregunta->id_pregunta); // la activamos 
        $pregunta->opciones = $this->getOpciones($pregunta->id_pregunta); // añadimos las opciones a la pregunta
        return $pregunta; // devolvemos 
        }
    static function getAll()
     {
        $db = new \zfx\DB();
        $id_user = 1;
        //$qry = "SELECT * FROM ponencias WHERE id_user =  $id_user ";
        $qry = "SELECT * FROM ponencias  ";
        return $db->qa($qry);
     }
    static function grabarRespuesta($id_pregunta, $id_opcion, $ip) // Graba la respuesta
        {
        $db = new \zfx\DB();
        $qry = "
        INSERT INTO respuestas (id_pregunta, id_opcion, ip)
        VALUES ($id_pregunta, $id_opcion, '$ip')
        ON CONFLICT (id_pregunta,  ip) 
            DO UPDATE
                SET id_opcion = $id_opcion
        ";
        return $db->q($qry); // Graba la respuesta
        }
    public function resultados($id_ponencia)    // Obtenemos los resultados de las votaciones
    
        {
        // en primer ligar, recuperamos la lista de las preguntas
        $qry = "
        SELECT * FROM preguntas
        WHERE id_ponencia = $id_ponencia
        ORDER BY orden
        ";
        $preguntas = $this->db->qa($qry); // Obtenemos todas las preguntas de la ponencia
        foreach ($preguntas as &$pregunta)
        {
            $qry = "
            SELECT COUNT(*) FROM respuestas
            WHERE id_pregunta = {$pregunta['id_pregunta']}
            ";
            $totalVotosPregunta = $this->db->qobj($qry); // Obtenemos el número de votos de la pregunta
            $pregunta['totalVotos'] = $totalVotosPregunta->count; // añadimos el total de votos a la pregunta
            $qry = "
            SELECT * FROM opciones
            WHERE id_pregunta = {$pregunta['id_pregunta']}
            ORDER BY id_opcion
            ";
            $opciones = $this->db->qa($qry); // Obtenemos todas las opciones de la pregunta
            foreach ($opciones as &$opcion)
            {
                $qry = "
                SELECT COUNT(*) FROM respuestas
                WHERE id_opcion = {$opcion['id_opcion']}
                ";
                $votos = $this->db->qobj($qry); // Obtenemos el número de votos de la opción
                $opcion['votos'] = $votos->count;
                if($pregunta['totalVotos'] > 0)
                    {
                    $opcion['pc'] = round(($votos->count / $pregunta['totalVotos']) * 100, 2); // calculamos el porcentaje de votos
                    }
                else
                    {
                    $opcion['pc'] = 0; // no hay votos
                    }
            }
            $pregunta['opciones'] = $opciones; // añadimos las opciones a la pregunta
        }
    
        return $preguntas; // devolvemos la lista de preguntas con sus opciones y resultados
        } 
    
}