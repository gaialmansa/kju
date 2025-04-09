<?php
/*
 * Fichero de menú de la aplicación
 */
//echo('<pre>');
// print_r(\zfx\Config::getInstance());
// die;

$menu = \zfx\Config::get('admMenu');



// Grupo Cuenta. Aquí uno puede cambiar su contraseña, salir, etc.
$pofemenu = array(
    'es'       => array('Ponencias', '<i class="fas fa-comments"></i> '),
    'perm'     => '',
    'sections' => array(
        'pofemenu-tablas' => array(
            'es'          => array('Ponencias','Administración', '<i class="fas fa-comments"></i> '),
            'perm'        => '',
            'subsections' => array
            (
                'pofemenu-mis-ponencias' => array(
                    'es'         => array('Mis ponencias', '<i class="fas fa-users"></i>'),
                    'controller' => 'mis-ponencias',
                    'perm'       => 'ponentes',
                ),
                'pofemenu-mis-preguntas' => array(
                    'es'         => array('Preguntas/ponencia', '<i class="fas fa-pager"></i>'),
                    'controller' => 'mis-preguntas',
                    'perm'       => 'ponentes',
                ),
                'pofemenu-mis-opciones' => array(
                    'es'         => array('Opciones/Pregunta', '<i class="fas fa-pager"></i>'),
                    'controller' => 'mis-opciones',
                    'perm'       => 'ponentes',
                ),'pofemenu-accion' => array(
                    'es'         => array('Acción', '<i class="fas fa-pager"></i>'),
                    'controller' => 'Accion',
                    'perm'       => 'ponentes',
                )
            )
        ),
    )
);


$menu['pofemenu'] = $pofemenu;





$cfg['appMenu'] = $menu;
