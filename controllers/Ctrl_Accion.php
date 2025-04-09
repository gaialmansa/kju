<?php

include_once('Abs_AppController.php');

class Ctrl_Accion extends Abs_AppController
{ public function _init()
    {
           $this->db = New \zfx\DB();
    }
   public function _main()
    {
           $res = $this->_autoexec();
           if (!$res) 
                   die("Action not found");
           

    }

    // --------------------------------------------------------------------

    public function _getCurrentSection()
    {
        return 'inicio';
    }

    // --------------------------------------------------------------------

    public function _getCurrentSubSection()
    {
        return '';
    }

    // --------------------------------------------------------------------

}
