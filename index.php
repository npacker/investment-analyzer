<?php

namespace App;

use App\Environment;

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
 * Shorthand for the current directory of "bootstrap.php" (this file).
 *
 * @var string
 */
define('ROOT', __DIR__);

ob_start();

require_once ROOT . DS . 'app' . DS . 'src' . DS . 'Environment.php';

$environment = new Environment();
$app = $environment->bootstrap();

switch ($app->request()->path()) {

  case '/':
    require 'routes' . DS . 'main.php';
    break;

  case '/portfolios':
    require 'routes' . DS. 'portfolios.php';
    break;

  case '/portfolios/create':
    require 'routes' . DS . 'portfolios' . DS . 'create.php';
    break;

  case '/funds':
    require 'routes' . DS . 'funds.php';
    break;

  case '/securities':
    require 'routes' . DS . 'securities.php';
    break;

  case '/overlap':
    require 'routes' . DS . 'overlap.php';
    break;

  default:
    break;

}

ob_end_flush();
exit();
