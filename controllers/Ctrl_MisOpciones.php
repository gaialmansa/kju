
<?php
/*
  Zerfrex (R) RAD ADM
  Zerfrex RAD for Administration & Data Management

  Copyright (c) 2013-2022 by Jorge A. Montes Pérez <jorge@zerfrex.com>
  All rights reserved. Todos los derechos reservados.

  Este software solo se puede usar bajo licencia del autor.
  El uso de este software no implica ni otorga la adquisición de
  derechos de explotación ni de propiedad intelectual o industrial.
 */

use zfx\Config;

include_once('Abs_AppController.php');

class Ctrl_MisOpciones extends Abs_AppController
{

    public function _main()
    {
        $this->_view->addSection('body', 'zaf/' . Config::get('admTheme') . '/crud-bootstrap-search', array(
            '_title'      => 'Buscar respuesta',
            '_controller' => 'MisOpcionesCrud',
            '_autoFocus'  => TRUE
        ));
        
        $this->_view->addSection('body', 'zaf/' . Config::get('admTheme') . '/crud-bootstrap-list', array(
            '_title'      => 'Respuestas actuales',
            '_controller' => 'MisOpcionesCrud'
        ));

        $this->_view->show();
    }

    // --------------------------------------------------------------------

    public function _getCurrentSection()
    {
        return '';
    }

    // --------------------------------------------------------------------

    public function _getCurrentSubSection()
    {
        return '';
    }

    // --------------------------------------------------------------------

}