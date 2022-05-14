<?php

namespace App\Container;

final class ContainerBuilder {

  public function create(ContainerDefinitionInterface $definition) {
    $container = new Container();

    foreach ($definition->services() as $name => $service) {
      $container->set($name, $service);
    }

    foreach ($definition->parameters() as $name => $parameter) {
      $container->setParameter($name, $parameter);
    }

    return $container;
  }

}
