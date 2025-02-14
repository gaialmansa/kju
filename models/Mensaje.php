<?php

class  Mensaje
{
        public $db;

    public function __construct($db)
    {
        $this->db = $db;
    }  
    public function crear($id_usuario_o, $mensaje)
    {
                $timestamp = date('Y-m-d H:i:s', time());
                $qry = "
                INSERT INTO mensajes
                (id_usuario_o,  hora_edicion, mensaje)
                VALUES ($id_usuario_o,'$timestamp', '$mensaje')
                RETURNING id_mensaje";
                return $this->db->qr($qry)['id_mensaje'];
    }
    public function enlazarMensajeUsuario($id_mensaje, $id_usuario)
    {
            $qry = "
            INSERT INTO rmu
            (id_mensaje, id_usuario)
            VALUES
             ($id_mensaje, $id_usuario)";
            $this->db->q($qry);
    }
    public function recuperarUsuariosGrupo($id_grupo)
    {
        $qry = "
          SELECT * FROM rug
              NATURAL JOIN usuarios
              NATURAL JOIN grupos
          WHERE id_grupo = $id_grupo";
        return $this->db->qa($qry);
    }
    public function recuperar($id_usuario, $nmensajes, $offset)
    {
        $qry = "
        SELECT uo.nombre AS origen,hora_edicion AS hora,mensaje, rmu.*
        FROM rmu
                NATURAL JOIN usuarios
                NATURAL JOIN mensajes
                JOIN usuarios uo ON mensajes.id_usuario_o = uo.id_usuario
        WHERE rmu.id_usuario = $id_usuario
        ORDER BY hora_edicion DESC 
        LIMIT $nmensajes
        OFFSET $offset";
        $listamensajes = $this->db->qa($qry);
        
        foreach ($listamensajes as &$m)
        {
        $idm = $m['id_mensaje'];
        $qry = "
                SELECT visto FROM rmu WHERE id_mensaje = $idm AND  NOT visto
                ";      // este query devuelve resultados si hay algun destinatario que aun no haya visto el mensaje
            $m['visto'] =  ! $this->db->qa($qry);

            $qry = "
                SELECT atendido FROM rmu WHERE id_mensaje = $idm AND  NOT atendido
            ";      // este query devuelve resultados si hay algun destinatario que aun no haya atendido el mensaje
            $m['atendido'] =  ! $this->db->qa($qry);
            
            $qry = "
                SELECT rehusado FROM rmu WHERE id_mensaje = $idm AND  NOT rehusado
            ";      // este query devuelve resultados si hay algun destinatario que aun no haya rehusado el mensaje
            $m['rehusado'] =  ! $this->db->qa($qry);
        }
        return $listamensajes;
    }
    public function recuperarPrimeroNoVisto($id_usuario)
    {
        $qry = "
        SELECT uo.nombre AS origen,hora_edicion AS hora,mensaje, rmu.*
        FROM rmu
         NATURAL JOIN usuarios
         NATURAL JOIN mensajes
         JOIN usuarios uo ON mensajes.id_usuario_o = uo.id_usuario
        WHERE rmu.id_usuario = $id_usuario AND NOT visto
        ORDER BY hora_edicion ";
        
        return $this->db->qr($qry);
    }
    public function ver($id)
    {
        $timestamp = $fechaHora = date('Y-m-d H:i:s', time());
        $qry = "
        UPDATE rmu
        SET visto = TRUE, hora_visto ='$timestamp' 
        WHERE id = $id";
        return $this->db->q($qry);
    }
    public function atender($id)
    {
        $timestamp = $fechaHora = date('Y-m-d H:i:s', time());
        $qry = "
                UPDATE rmu
                SET atendido = TRUE, hora_atendido ='$timestamp' 
                WHERE id = $id";
        return $this->db->q($qry);
    }
    public function rehusar($id)
    {
        $timestamp = $fechaHora = date('Y-m-d H:i:s', time());
        $qry = "
                UPDATE rmu
                SET rehusado = TRUE, hora_rehusado ='$timestamp' 
                WHERE id = $id";
        return $this->db->q($qry);
    }

    public function enviadosRecuperar($id_usuario, $numero)
    {
        $qry = "
        SELECT hora_edicion AS hora,mensaje, rmu.*
        FROM rmu
                NATURAL JOIN usuarios
                NATURAL JOIN mensajes
        WHERE mensajes.id_usuario_o = $id_usuario
        ORDER BY hora DESC
        LIMIT $numero";
        return $this->db->qa($qry);
    }
    
}
