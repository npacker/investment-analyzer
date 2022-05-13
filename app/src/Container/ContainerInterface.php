<?php

namespace App\Container;

interface ContainerInterface {

  public function get(string $name);

  public function has(string $name);

  public function set(string $name, ServiceInterface $service);

  public function getParameter(string $name);

  public function hasParameter(string $name);

  public function setParameter(string $name, $value);

}
