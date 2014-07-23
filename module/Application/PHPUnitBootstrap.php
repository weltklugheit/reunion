<?php

/*
 * The MIT License
 *
 * Copyright 2014 hbaeumer.
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
namespace Application;

use RuntimeException;
use Zend\Mvc\Service\ServiceManagerConfig;
use Zend\ServiceManager\ServiceManager;

/**
 * Test bootstrap, for setting up autoloading
 */
class PHPUnitBootstrap
{
    /**
     * Service manager
     *
     * @var ServiceManager
     */
    protected static $serviceManager;

    /**
     * Initialize the bootstrap
     */
    public static function init()
    {
        if (!defined('APPLICATION_PATH')) {
            define('APPLICATION_PATH', realpath(__DIR__ . '/../..'));
        }

        static::initAutoloader();

        $configuration = include APPLICATION_PATH.'/config/application.config.php';

        $smConfig = isset($configuration['service_manager']) ? $configuration['service_manager'] : array();
        //$listeners = isset($configuration['listeners']) ? $configuration['listeners'] : array();
        $serviceManager = new ServiceManager(new ServiceManagerConfig($smConfig));
        $serviceManager->setService('ApplicationConfig', $configuration);
        $serviceManager->get('ModuleManager')->loadModules();
        static::$serviceManager = $serviceManager;
    }

    /**
     * Get Service Manager
     *
     * @return ServiceManager
     */
    public static function getServiceManager()
    {
        return static::$serviceManager;
    }

    /**
     * Initialize autoloader
     *
     * @throws RuntimeException
     */
    protected static function initAutoloader()
    {
        chdir(APPLICATION_PATH);
        require APPLICATION_PATH.'/init_autoloader.php';
    }

    /**
     * Find the parent path
     *
     * @param  string $path
     * @return string
     */
    protected static function findParentPath($path)
    {
        $dir = __DIR__;
        $previousDir = '.';
        while (!is_dir($dir . '/' . $path)) {
            $dir = dirname($dir);
            if ($previousDir === $dir) {
                return false;
            }
            $previousDir = $dir;
        }

        return $dir . '/' . $path;
    }
}

PHPUnitBootstrap::init();
