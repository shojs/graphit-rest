<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Gi\Controller\Gi' => 'Gi\Controller\GiController',
        ),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'album' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/gi[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
//                         'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Gi\Controller\Gi',
                        'action'     => 'login',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'gi' => __DIR__ . '/../view',
        ),
    ),
);