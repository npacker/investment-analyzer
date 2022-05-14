<?php

namespace App\Container;

final class ServiceDefinition implements ServiceDefinitionInterface {

  private $name;

  private $class;

  private $arguments;

  private $shared;

  public function __construct(string $name, array $definition) {
    $this->name = $name;
    $this->class = $definition['class'];
    $this->arguments = $definition['arguments'] ?? [];
    $this->shared = $definition['shared'] ?? true;
  }

  public function name() {
    return $this->name;
  }

  public function class() {
    return $this->class;
  }

  public function arguments() {
    $definition = [];

    foreach ($this->arguments as $argument) {
      $is_service = (bool) preg_match('/^@(.+)$/', $argument, $service);
      $is_parameter = (bool) preg_match('/^%(.+)%$/', $argument, $parameter);

      if ($is_service) {
        $name = $service[1];
        $definition[$name] = new ArgumentDefinition('service', $name);
      }

      if ($is_parameter) {
        $name = $parameter[1];
        $definition[$name] = new ArgumentDefinition('parameter', $name);
      }
    }

    return $definition;
  }

  public function shared() {
    return $this->shared;
  }

}
