<?php
return array(
    'controller_plugins' => array(
        'classes' => array(
            //'test' => 'Test\Controller\Plugin\Test'
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            //'file-manager' => __DIR__ . '/../view',
        ),
    ),
    'router' => array(
        'routes' => array(
            'file-manager' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/file-manager',
                    'defaults' => array(
                        '__NAMESPACE__' => 'KapitchiFileManager\Controller',
                    ),
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    'manager' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/manager',
                            'defaults' => array(
                                'controller' => 'Manager',
                                'action' => 'index'
                            ),
                        ),
                    ),
                    'downloader' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/downloader',
                            'defaults' => array(
                                'controller' => 'Downloader',
                            ),
                        ),
                    ),
                    'api' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/api',
                            'defaults' => array(
                                '__NAMESPACE__' => 'KapitchiFileManager\Controller\Api',
                            ),
                        ),
                        'may_terminate' => false,
                        'child_routes' => array(
                            'file-index' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/file-index[/:action][/:id]',
                                    'constraints' => array(
                                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'FileIndex',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
