<?php

namespace App\Storage\Schema;

use App\Storage\Schema\StorageSchemaDefinitionInterface;

final class StorageSchemaDefinition implements StorageSchemaDefinitionInterface {

  private string $name;

  private string $class;

  public function __construct(string $name, array $definition) {
    $this->name = $name;
    $this->class = $definition['class'];
  }

  public function name(): string {
    return $this->name;
  }

  public function class(): string {
    return $this->class;
  }

}
