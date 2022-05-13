<?php

namespace App\Container;

final class Container implements ContainerInterface {

  private $services = [];

  private $parameters = [];

  public function get(string $name) {
    return $this->services[$name];
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

}
