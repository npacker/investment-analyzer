<?php

namespace App\Container;

use App\Container\ContainerInterface;

interface ContainerInjectionInterface {

  public function create(ContainerInterface $container);

}
