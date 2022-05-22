<?php

namespace App\Render;

use App\Render\TemplateFacadeInterface;

abstract class AbstractTemplateFacade implements TemplateFacadeInterface {

  protected array $variables = [];

  final public function set(string $name, $value) {
    $this->variables[$name] = $value;

    return $this;
  }

  final public function has(string $name): bool {
    return isset($this->variables[$name]);
  }

  final public function get(string $name) {
    return $this->variables[$name];
  }

  final public function unset(string $name) {
    unset($this->variables[$name]);

    return $this;
  }

  final public function variables(): array {
    return $this->variables;
  }

}
