<?php

/*
 * The MIT License
 *
 * Copyright 2014 heiner.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

return array(
    'doctrine' => array(
        'driver' => array(
            // overriding zfc-user-doctrine-orm's config
            'world_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/World/Entity',
            ),
            'orm_default'    => array(
                'drivers' => array(
                    'World\Entity' => 'world_entities',
                ),
            ),
        ),
    ),
    'console'  => array(
        'router' => array(
            'routes' => array(
                'galaxy-generate-planetarySystems' => array(
                    'type'    => 'simple',
                    'options' => array(
                        'route'    => 'galaxy generate planetarySystems',
                        'defaults' => array(
                            'controller' => 'World\Controller\Console',
                            'action'     => 'new',
                        ),
                    ),
                )
            )
        )
    ),
    'router'          => array(
        'routes' => array(
            'galaxy' => array(
                'type'          => 'Literal',
                'options'       => array(
                    'route'    => '/galaxy',
                    'defaults' => array(
                        '__NAMESPACE__' => 'World\Controller',
                        'controller'    => 'Galaxy',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes'  => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'       => '/[:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults'    => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'controllers'     => array(
        'invokables' => array(
            'World\Controller\Galaxy' => 'World\Controller\GalaxyController',
            'World\Controller\Console' => 'World\Controller\ConsoleController'
        ),
    ),
    'view_manager'    => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'World\Service\Galaxy'          => 'World\Service\Factory\GalaxyServiceFactory',
            'World\Service\Star'            => 'World\Service\Factory\StarServiceFactory',
            'World\Service\Planet'          => 'World\Service\Factory\PlanetServiceFactory',
            'World\Service\PlanetarySystem' => 'World\Service\Factory\PlanetarySystemServiceFactory',
            'World\Service\StarSystem'      => 'World\Service\Factory\StarSystemServiceFactory',
        ),
    ),
);

