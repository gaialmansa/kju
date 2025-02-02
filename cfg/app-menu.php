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
    'es'       => array('Mensajería', '<i class="fas fa-comments"></i> '),
    'sections' => array(
        'pofemenu-tablas' => array(
            'es'          => array('Mensajería - Administración', '<i class="fas fa-comments"></i> '),
            'subsections' => array
            (
                'pofemenu-tablas-usuarios' => array(
                    'es'         => array('Usuarios', '<i class="fas fa-user-nurse"></i>'),
                    'controller' => 'usuarios',
                    'perm'       => '|',
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
                )
            )
        ),
    )
);


$menu['pofemenu'] = $pofemenu;





$cfg['appMenu'] = $menu;