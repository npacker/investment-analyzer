<?php

namespace App\Container;

interface ArgumentDefinitionInterface {

  public function name();

  public function resolve(ContainerInterface $container);

}
