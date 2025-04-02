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
            'es'          => array('Ponencias' - Administración', '<i class="fas fa-comments"></i> '),
            'perm'        => '',
            'subsections' => array
            (
                'pofemenu-tablas-ponencias' => array(
                    'es'         => array('Ponencias', '<i class="fas fa-user-nurse"></i>'),
                    'controller' => 'ponencias',
                    'perm'       => 'menu-ponencias-usuarios',
                ),
                'pofemenu-tablas-grupos' => array(
                    'es'         => array('Grupos de usuarios', '<i class="fas fa-users"></i>'),
                    'controller' => 'grupos',
                    'perm'       => '|',
                ),
                'pofemenu-asignar-busca' => array(
                    'es'         => array('Asignar Busca', '<i class="fas fa-pager"></i>'),
                    'controller' => 'asignar-beeper',
                    'perm'       => '|',
                ),
                'pofemenu-enviar-mensaje' => array(
                    'es'         => array('Enviar mensaje', '<i class="fas fa-pager"></i>'),
                    'controller' => 'enviar-mensaje',
                    'perm'       => '|',
                )
            )
        ),
    )
);


$menu['pofemenu'] = $pofemenu;





$cfg['appMenu'] = $menu;
