<?php

namespace App\Router;

use App\Router\Route;

final class RouteMatch {

  private $route;

  private $parameters;

  private $success;

  public function __construct(Route $route, array $parameters, bool $success) {
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
