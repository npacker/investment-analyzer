<?php

namespace App\Router;

use App\Router\RouteInterface;

interface RouteFactoryInterface {

  public function create(string $path, string $controller, string $action, array $methods): RouteInterface;

}
