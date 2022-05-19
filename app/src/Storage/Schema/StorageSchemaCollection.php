<?php

namespace App\Storage\Schema;

use PDOException;

final class StorageSchemaCollection {

  private StorageSchemaCollectionDefinition $definition;

  public function __construct(StorageSchemaCollectionDefinition $definition) {
    $this->definition = $definition;
  }

  public function build() {
    foreach ($this->definition->schema() as $name => $value) {
      $instance = new $value();

      try {
        $instance->build();
      }
      catch (PDOException $e) { }
    }
  }

}
