<?php
define('REQUEST_MICROTIME', microtime(true));
chdir(dirname(__DIR__));
define('APPLICATION_PATH', realpath(__DIR__ . '/..'));

// Setup autoloading
require 'init_autoloader.php';

Zend\Mvc\Application::init(require 'config/application.config.php')->run();