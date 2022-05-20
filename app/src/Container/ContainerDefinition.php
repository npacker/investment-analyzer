<?php

namespace App\Container;

use App\Container\ContainerDefinitionInterface;
use App\Container\ServiceDefinition;

final class ContainerDefinition implements ContainerDefinitionInterface {

  private array $services;

  private array $parameters;

  public function __construct(array $definition) {
    $this->services = $definition['services'] ?? [];
    $this->parameters = $definition['parameters'] ?? [];
  }

  public function services(): array {
    $definition = [];

    foreach ($this->services as $name => $service) {
      $definition[$name] = new ServiceDefinition($name, $service);
    }

    return $definition;
  }

  public function parameters(): array {
    return $this->parameters;
  }

}
