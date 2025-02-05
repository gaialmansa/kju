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
        SELECT id_beeper
        FROM beepers
        WHERE mac = '$mac'";
        $ret = $this->db->qa($qry);
//        return $qry;
        if (!$ret)  // si no encuentra nada devuelve falso
            return false;
        return $ret;
    }
    public function borrar($mac)
    {
        $qry = "DELETE FROM beepers WHERE mac = '$mac'";
        return $this->db->q($qry);
    }
}