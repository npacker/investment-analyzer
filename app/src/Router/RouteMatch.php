<?php

namespace App\Router;

final class RouteMatch implements RouteMatchInterface {

  private $route;

  private $parameters;

  private $success;

  public function __construct(RouteInterface $route, array $parameters, bool $success) {
    $this->route = $route;
    $this->parameters = $parameters;
    $this->success = $success;
  }

  public function route() {
    return $this->route;
  }

  public function parameters() {
    return $this->parameters;
  }

  public function success() {
    return $this->success;
  }

}
