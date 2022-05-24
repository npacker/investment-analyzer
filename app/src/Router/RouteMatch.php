<?php

namespace App\Router;

use App\Router\RouteInterface;
use App\Router\RouteMatchInterface;

final class RouteMatch implements RouteMatchInterface {

  private RouteInterface $route;

  private array $parameters;

  private bool $success;

  public function __construct(RouteInterface $route, array $parameters, bool $success) {
    $this->route = $route;
    $this->parameters = $parameters;
    $this->success = $success;
  }

  public function route(): RouteInterface {
    return $this->route;
  }

  public function parameters(?string $name) {
    if (isset($name)) {
      return $this->parameters[$name] ?? null;
    }
    else {
      return $this->parameters;
    }
  }

  public function success(): bool {
    return $this->success;
  }

}
