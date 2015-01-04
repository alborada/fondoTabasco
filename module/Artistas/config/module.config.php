<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Artistas\Controller\Index' => 'Artistas\Controller\IndexController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'artistas' => array(
                'type'    => 'segment',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/artistas[/:controller][/:action][/:id]',
                    'constraints' => array(
                        'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        ),
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Artistas\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller][/:action][/:id]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '[0-9]+',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
    'paginator' => array(
        'type' => 'segment',
            'options' => array(
                'route' => '/artistas[/:controller][/:action]/page[/:page]',
                'constraints' => array(
                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                'page' => '[0-9]+',
                ),
                'defaults' => array(
                    '__NAMESPACE__' => 'Artistas\Controller',
                    'controller' => 'Index',
                    'action' => 'index',
                    'page' => 1,
                ),
            ),
    ),            
    ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'Artistas' => __DIR__ . '/../view',
        ),
    ),
);
