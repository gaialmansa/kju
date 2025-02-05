<?php

class  Beepers
{
        public $db;

    public function __construct($db)
    {
        $this->db = $db;
    }   
    public function insertar($mac)
    {
        $qry = "INSERT INTO beepers (mac) VALUES ('$mac')";
        return $this->db->q($qry);
    }
    public function existe($mac)
    {
        $qry = "
        SELECT usuarios.nombre
        FROM beepers
            NATURAL JOIN usuarios
        WHERE mac = '$mac'";
        $ret = $this->db->qa($qry);
        if (is_null($ret))  // si no encuentra nada devuelve falso
            return false;
        return $ret['nombre'];
    }
    public function borrar($mac)
    {
        $qry = "DELETE FROM beepers WHERE mac = '$mac'";
        return $this->db->q($qry);
    }
}