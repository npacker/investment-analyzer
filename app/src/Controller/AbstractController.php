<?php

namespace App\Controller;

use App\App;
use App\Container\ContainerInterface;
use App\Controller\ControllerInterface;
use Twig\Environment as TwigEnvironment;

abstract class AbstractController implements ControllerInterface {

  protected ContainerInterface $container;

  public function __construct(ContainerInterface $container) {
    $this->container = $container;
  }

  protected function twig(): TwigEnvironment {
    return $this->container->get('twig');
  }

}
