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
        SELECT *
        FROM beepers
        WHERE mac = '$mac'";
        $ret = $this->db->qa($qry);;
        if (!$ret)  // si no encuentra nada devuelve falso
            return false;
        else        // ha encontrado algo. Tenemos que buscar a ver si está asignado
        {
            echo var_dump($ret[0]);
            if ($reṭ[0]['id_usuario'] <> '') // usuario no asignado
            {
                $qry = "
                        SELECT *
                        FROM beepers
                         NATURAL JOIN usuarios
                        WHERE mac = '$mac'";
                        echo $qry;
                        $ret = $this->db->qa($qry);;
            }
        }
        return $ret[0];
    }
    public function borrar($mac)
    {
        $qry = "DELETE FROM beepers WHERE mac = '$mac'";
        return $this->db->q($qry);
    }
}