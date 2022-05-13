<?php

namespace App\Container;

final class ContainerDefinition implements ContainerDefinitionInterface {

  private $services;

  private $parameters;

  public function __construct(array $definition) {
    $this->services = $definition['services'] ?? [];
    $this->parameters = $definition['parameters'] ?? [];
  }

  public function services() {
    $definition = [];

    foreach ($this->services as $name => $service) {
      $definition[$name] = new ServiceDefinition($name, $service);
    }

    return $definition;
  }

  public function parameters() {
    return $this->parameters;
  }

}
