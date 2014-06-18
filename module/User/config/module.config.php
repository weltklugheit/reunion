<?php

return array(
    'doctrine'     => array(
        'driver' => array(
            // overriding zfc-user-doctrine-orm's config
            'zfcuser_entity' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/User/Entity',
            ),
            'orm_default'    => array(
                'drivers' => array(
                    'User\Entity' => 'zfcuser_entity',
                ),
            ),
        ),
    ),
    'zfcuser'      => array(
        // telling ZfcUser to use our own class
        'user_entity_class'       => 'User\Entity\User',
        // telling ZfcUserDoctrineORM to skip the entities it defines
        'enable_default_entities' => false,
    ),
    'bjyauthorize' => array(
        'default_role'       => 'guest',
        'authenticated_role' => 'user',
        // Using the authentication identity provider, which basically reads the roles from the auth service's identity
        'identity_provider'  => 'BjyAuthorize\Provider\Identity\AuthenticationIdentityProvider',
        'role_providers'     => array(
            // using an object repository (entity repository) to load all roles into our ACL
            'BjyAuthorize\Provider\Role\ObjectRepositoryProvider' => array(
                'object_manager'    => 'doctrine.entitymanager.orm_default',
                'role_entity_class' => 'User\Entity\Role',
            ),
        ),
    ),
     'console'  => array(
        'router' => array(
            'routes' => array(
                'create-admin' => array(
                    'type'    => 'simple',
                    'options' => array(
                        'route'    => 'create user <role> <email>',
                        'defaults' => array(
                            'controller' => 'User\Controller\Console',
                            'action'     => 'create-admin',
                        ),
                    ),
                )
            )
        )
    ),

    'controllers' => array(
        'invokables' => array(
            'User\Controller\Console'=> 'User\Controller\ConsoleController',
        ),
    ),
    
    'view_manager'    => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    
    

);
