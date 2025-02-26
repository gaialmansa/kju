<?php
class Puser
{
    
    public $db;

    public function __construct($db)
    {
        $this->db = $db;
    }
    public function buscarRegistro($numero) // busca en BD si el numero está registrado. Devuelve el id_usuario
    {
        $qry = "
        SELECT id_usuario 
        FROM registro
        WHERE numero = $numero";
        $ret = $this->db->qo($qry);
        return $ret;
    }
    public function registrar($id_usuario, $numero)
    {
        $qry = "
        INSERT INTO registro
        (id_usuario,numero)
        VALUES
        ($id_usuario,$numero)";
        $ret = $this->db->qo($qry);
        return $ret;
    }
    public function getUsuarios()
    {
        $qry = "
                SELECT * 
                FROM USUARIOS
                ORDER BY nombre
        ";
        return $this->db->qa($qry);
    }


}