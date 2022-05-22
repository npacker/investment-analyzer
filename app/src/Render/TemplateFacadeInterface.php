<?php

namespace App\Render;

interface TemplateFacadeInterface {

  public function set(string $name, $value);

  public function has(string $name): bool;

  public function get(string $name);

  public function unset(string $name);

  public function variables(): array;

  public function render(): string;

}
