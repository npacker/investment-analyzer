<?php

namespace App\Container;

use App\Container\ServiceDefinitionInterface;

interface ContainerInterface {

  public function get(string $name);

  public function has(string $name): bool;

  public function set(string $name, ServiceDefinitionInterface $service);

  public function getParameter(string $name);

  public function hasParameter(string $name): bool;

  public function setParameter(string $name, $value);

}
