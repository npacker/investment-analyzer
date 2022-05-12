<?php

namespace App\Router;

interface RouteFactory {

  public function create(string $path, string $controller, string $action, array $methods);

}
