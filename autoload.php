<?php

/**
 * Shorthand for the platform-specific directory separator.
 *
 * @var string
 */
define('DS', DIRECTORY_SEPARATOR);

/**
 * Shorthand for the platform-specific path separator.
 *
 * @var string
 */
define('PS', PATH_SEPARATOR);

/**
 * Shorthand for the application root.
 *
 * @var string
 */
define('ROOT', __DIR__);

$autoloader = require ROOT . DS . 'vendor' . DS . 'autoload.php';
$autoloader->addPsr4('App\\', ROOT . DS . 'app' . DS . 'src');

return $autoloader;
