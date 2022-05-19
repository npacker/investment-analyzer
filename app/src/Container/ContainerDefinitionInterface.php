<?php

namespace App\Container;

interface ContainerDefinitionInterface {

  public function services(): array;

  public function parameters(): array;

}
