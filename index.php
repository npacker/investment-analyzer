<?php

namespace App;

use App\Environment;

$autoloader = require 'autoload.php';
$environment = new Environment($autoloader);
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

  case '/funds/create':
    require 'routes' . DS . 'funds' . DS . 'create.php';
    break;

  case '/securities':
    require 'routes' . DS . 'securities.php';
    break;

  case '/overlap':
    require 'routes' . DS . 'overlap.php';
    break;

  default:
    require 'routes' . DS . '404.php';
    break;

}
