<?php

namespace App\Container;

final class Container implements ContainerInterface {

  private $services = [];

  private $parameters = [];

  private $instances = [];

  public function get(string $name) {
    if (isset($this->instances[$name])) {
      return $this->instances[$name];
    }

    $definition = $this->services[$name];
    $class = $definition->class();
    $arguments = $this->resolveArgumentsAndParameters($definition);
    $instance = new $class(...$arguments);

    if ($definition->shared()) {
      $this->instances[$name] = $instance;
    }

    return $instance;
  }

  public function has(string $name) {
    return array_key_exists($name, $this->services);
  }

  public function set(string $name, ServiceDefinitionInterface $service) {
    $this->services[$name] = $service;
  }

  public function getParameter(string $name) {
    return $this->parameters[$name];
  }

  public function hasParameter(string $name) {
    return array_key_exists($name, $this->parameters);
  }

  public function setParameter(string $name, $value) {
    $this->parameters[$name] = $value;
  }

  private function resolveArgumentsAndParameters(ServiceDefinitionInterface $definition) {
    $arguments = [];

    foreach ($definition->arguments() as $name => $argument) {
      if ($argument->type() === 'service') {
        $arguments[] = $this->get($argument->name());
      }

      if ($argument->type() === 'parameter') {
        $arguments[] = $this->getParameter($argument->name());
      }
    }

    return $arguments;
  }

}