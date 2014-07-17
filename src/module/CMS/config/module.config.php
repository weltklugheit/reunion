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
    'doctrine'     => array(
        'driver' => array(
            // overriding zfc-user-doctrine-orm's config
            'cms_entities' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/CMS/Entity',
            ),
            'orm_default'    => array(
                'drivers' => array(
                    'CMS\Entity' => 'cms_entities',
                ),
            ),
        ),
    ),
    'router' => array(
        'routes' => array(
            'cms' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/:name.html[/:action]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'CMS\Controller',
                        'controller'    => 'Article',
                        'action'        => 'show',
                    ),
                ),
                'may_terminate' => true,
            ),
             'cms-new' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/cms/:action/[/:controller]',
                    'defaults' => array(
                        '__NAMESPACE__' => 'CMS\Controller',
                        'controller'    => 'Article',
                    ),
                ),
                'may_terminate' => true,
            ),
        ),
    ),
    
    'controllers' => array(
        'invokables' => array(
            'CMS\Controller\Article' => 'CMS\Controller\ArticleController',
        ),
    ),
    'view_manager'    => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);