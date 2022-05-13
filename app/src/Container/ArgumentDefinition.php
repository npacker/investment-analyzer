<?php

namespace App\Container;

final class ArgumentDefinition implements ArgumentDefinitionInterface {

  private $type;

  private $name;

  public function __construct(string $type, string $name) {
    $this->type = $type;
    $this->name = $name;
  }

  public function type() {
    return $this->type;
  }

  public function name() {
    return $this->name;
  }

}
