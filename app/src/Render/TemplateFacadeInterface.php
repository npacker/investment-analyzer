<?php

namespace App\Render;

interface TemplateFacadeInterface {

  public function render(): string;

  public function variables(): array;

  public function __set(string $name, $value): void;

  public function __isset(string $name): bool;

  public function __get(string $name);

  public function __unset(string $name): void;

}
