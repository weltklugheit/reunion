<?php

return array(
    'modules'                 => array(
        'ZendDeveloperTools',
        'DoctrineModule',
        'DoctrineORMModule',
        'ZfcBase',
        'ZfcUser',
        'ZfcUserDoctrineORM',
        'Application',
    ),
    'module_listener_options' => array(
        'module_paths'             => array(
            './module',
            './vendor',
        ),
        'config_glob_paths'        => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
        'cache_dir'                => './data/cache',
        'config_cache_enabled'     => true,
        'module_map_cache_enabled' => false,
    ),
    'service_manager'         => array(
        'factories' => array(
            'Zend\Cache\StorageFactory' => function() {
                return Zend\Cache\StorageFactory::factory(
                    array(
                        'adapter' => array(
                            'name'    => 'filesystem',
                            'options' => array(
                                'ttl'            => 1800,
                                'dirLevel'       => 2,
                                'cacheDir'       => './data/cache',
                                'dirPermission'  => 0777,
                                'filePermission' => 0666,
                            ),
                        ),
                        'plugins' => array('serializer'),
                    )
                );
            }
        ),
        'aliases'                 => array(
            'cache' => 'Zend\Cache\StorageFactory',
        ),
    ),
);
