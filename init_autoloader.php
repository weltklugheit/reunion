<?php

// Composer autoloading
$loader = include 'vendor/autoload.php';
$zf2Path = 'vendor/ZF2/library';
$loader->add('Zend', $zf2Path);

if (!class_exists('Zend\Loader\AutoloaderFactory')) {
    throw new RuntimeException('Unable to load ZF2. Run `php composer.phar install` or define a ZF2_PATH environment variable.');
}
