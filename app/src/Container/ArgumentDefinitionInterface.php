<?php

namespace App\Container;

use App\Container\ContainerInterface;

interface ArgumentDefinitionInterface {

  public function name(): string;

  public function resolve(ContainerInterface $container);

}
