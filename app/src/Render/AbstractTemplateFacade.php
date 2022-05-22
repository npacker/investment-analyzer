<?php

namespace App\Render;

use App\Render\TemplateFacadeInterface;

abstract class AbstractTemplateFacade implements TemplateFacadeInterface {

  protected array $variables = [];

  final public function variables(): array {
    return $this->variables;
  }

  final public function __set(string $name, $value): void {
    $this->variables[$name] = $value;
  }

  final public function __isset(string $name): bool {
    return isset($this->variables[$name]);
  }

  final public function __get(string $name) {
    return $this->variables[$name];
  }

  final public function __unset(string $name): void {
    unset($this->variables[$name]);
  }

}
