<?php

namespace App\Router;

use App\Http\RequestInterface;

final class MethodMatchableRoute implements RouteInterface {

  private $route;

  private $methods;

  public function __construct(RouteInterface $route, array $methods = ['GET']) {
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

  public function methods() {
    return $this->methods;
  }

  public function match(RequestInterface $request) {
    if (in_array($request->server('REQUEST_METHOD'), $this->methods)) {
      return $this->route->match($request);
    }
    else {
      return new RouteMatch($request, [], FALSE);
    }
  }

}
