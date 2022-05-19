<?php

namespace App\Router;

use App\Http\RequestInterface;
use App\Router\RouteMatchInterface;

interface RequestMatchingInterface {

  public function match(RequestInterface $request): RouteMatchInterface;

}
