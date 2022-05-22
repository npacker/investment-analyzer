<?php

namespace App\Container;

use App\Container\ContainerInterface;

interface ContainerInjectionInterface {

  public static function create(ContainerInterface $container);

}
