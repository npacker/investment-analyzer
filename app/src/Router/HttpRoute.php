<?php

namespace App\Router;

use App\Http\Request;
use App\Router\NonMatchingRouteException;
use App\Router\Route;

final class HttpRoute implements Route {

  private $route;

  private $methods;

  public function __construct(Route $route, $methods = ['GET']) {
    $this->route = $route;
    $this->methods = $methods;
  }

  public function path() {
    return $this->route->path();
  }

  public function controller() {
    return $this->route->controller();
  }

  public function action() {
    return $this->route->action();
  }

  public function match(Request $request) {
    if (in_array($request->server('REQUEST_METHOD'), $this->methods)) {
      return $this->route->match($request);
    }
    else {
      throw new NonMatchingRouteException('Invalid request method.');
    }
  }

  public function methods() {
    return $this->methods;
  }

}
