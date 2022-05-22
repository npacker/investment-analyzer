<?php

namespace App\Storage\Schema;

use PDO;

final class StorageSchemaCollection {

  private PDO $handle;

  private StorageSchemaCollectionDefinition $definition;

  public function __construct(PDO $handle, StorageSchemaCollectionDefinition $definition) {
    $this->handle = $handle;
    $this->definition = $definition;
  }

  public function definition(): StorageSchemaCollectionDefinition {
    return $this->definition;
  }

  public function build() {
    foreach ($this->definition->schema() as $name => $storage_schema_definition) {
      $class = $storage_schema_definition->class();
      $instance = new $class($this->handle);

      $instance->build();
    }
  }

}
