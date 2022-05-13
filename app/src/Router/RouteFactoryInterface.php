<?php

namespace App\Router;

interface RouteFactoryInterface {

  public function create(string $path, string $controller, string $action, array $methods);

}
