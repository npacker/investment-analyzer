<?php

namespace App\Container;

interface ArgumentDefinitionInterface {

  public function name(): string;

  public function resolve(ContainerInterface $container);

}
