<?php

namespace App\Container;

final class Container implements ContainerInterface {

  private $definitions = [];

  private $parameters = [];

  private $services = [];

  private $loading = [];

  public function get(string $name) {
    if (isset($this->services[$name])) {
      return $this->services[$name];
    }

    if (isset($this->loading[$name])) {
      throw new CircularServiceReferenceException();
    }

    return $this->createService($name);
  }

  public function has(string $name) {
    return array_key_exists($name, $this->definitions) || array_key_exists($name, $this->services);
  }

  public function set(string $name, $service) {
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

  public function getDefinition(string $name) {
    return $this->definitions[$name];
  }

  public function hasDefinition(string $name) {
    return array_key_exists($name, $this->definitions);
  }

  public function setDefinition(string $name, ServiceDefinitionInterface $service) {
    $this->definitions[$name] = $service;
  }

  private function createService(string $name) {
    $this->loading[$name] = true;
    $definition = $this->definitions[$name];
    $class = $definition->class();
    $arguments = $this->resolveArgumentsAndParameters($definition);
    $service = new $class(...$arguments);

    if ($definition->shared()) {
      $this->services[$name] = $instance;
    }

    unset($this->loading[$name]);

    return $service;
  }

  private function resolveArgumentsAndParameters(ServiceDefinitionInterface $definition) {
    $arguments = [];

    foreach ($definition->arguments() as $name => $argument) {
      $arguments[] = $argument->resolve($this);
    }

    return $arguments;
  }

}
