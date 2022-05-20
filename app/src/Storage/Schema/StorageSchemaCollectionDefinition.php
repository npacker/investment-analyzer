<?php

namespace App\Storage\Schema;

final class StorageSchemaCollectionDefinition {

  private array $definition;

  public function __construct(array $definition) {
    $this->definition = $definition['schema'] ?? [];
  }

  public function schema(): array {
    $definitions = [];

    foreach ($this->definition as $name => $schema) {
      $definitions[$name] = new StorageSchemaDefinition($name, $schema);
    }

    return $definitions;
  }

}
