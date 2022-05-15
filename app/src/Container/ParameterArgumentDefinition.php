<?php

namespace App\Container;

final class ParameterArgumentDefinition implements ArgumentDefinitionInterface {

  private $name;

  public function __construct(string $name) {
    $this->name = $name;
  }

  public function name() {
    return $this->name;
  }

  public function resolve(ContainerInterface $container) {
    return $container->getParameter($this->name);
  }

}
