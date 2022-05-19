<?php

namespace App\Container;

final class ServiceArgumentDefinition implements ArgumentDefinitionInterface {

  private string $name;

  public function __construct(string $name) {
    $this->name = $name;
  }

  public function name(): string {
    return $this->name;
  }

  public function resolve(ContainerInterface $container) {
    return $container->get($this->name);
  }

}
