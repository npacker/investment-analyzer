<?php

namespace App\Storage\Schema;

final class StorageSchemaCollectionDefinition {

  private array $definition;

  public function __construct(array $definition) {
    $this->definition = $definition;
  }

  public function schema(): array {
    $schema = [];

    foreach ($this->definition as $name => $schema) {
      $schema[$name] = new StorageSchemaDefinition($name, $schema);
    }

    return $schema;
  }

}
