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
use function zfx\va;

include_once('Abs_AppCrudController.php');

class Ctrl_MisPonenciasCrud extends Abs_AppCrudController
{

    protected function initData()
    {
        $this->auto('ponencias');

        // Aprovechamos la clave foránea para mostrar usuarios en vez de numeros
        $this->relName('ponencias_id_user_fkey', 'login');

        // Rellenamos el usuario siempre en un nuevo registro
        $idUsuario = $this->_getUser()->getId();
        $this->defaultRS = [
            'id_user' => $idUsuario
        ];
        $this->nonEditableFields = [ 'id_user' ];

        // Filtramos para que solo se muestren las ponencias del usuario logueado.
        if (!$this->_getUser()->hasPermission('ver-todo')) {
            $this->applySessionFilter('ponencias-usuario', 'id_user', '', '', '', "id_user=$idUsuario");
        }
    }


    // --------------------------------------------------------------------
    protected function setupViewForm($packedID = '')
    {
        parent::setupViewForm($packedID);
        if ($packedID != '') {
            $this->addFrmSectionRel($packedID, 'preguntas_id_ponencia_fkey', 'MisPreguntasCrud', 'Preguntas');
        }
    }

    
    // --------------------------------------------------------------------
}
