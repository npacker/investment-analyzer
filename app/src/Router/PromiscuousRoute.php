<?php

namespace App\Router;

use App\Http\RequestInterface;

final class PromiscuousRoute implements RouteInterface {

  private $path;

  private $controller;

  private $action;

  private $methods;

  public function __construct(string $path, string $controller, string $action, array $methods = NULL) {
    $this->path = $path;
    $this->controller = $controller;
    $this->action = $action;
    $this->method = $methods;
  }

  public function path() {
    return $this->path;
  }

  public function controller() {
    return $this->controller;
  }

  public function action() {
    return $this->action;
  }

  public function methods() {
    return $this->methods;
  }

}
