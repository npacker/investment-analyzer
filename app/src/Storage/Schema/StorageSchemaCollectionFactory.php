<?php

namespace App\Storage\Schema;

use App\Storage\Schema\StorageSchemaCollection;
use App\Storage\Schema\StorageSchemaCollectionDefinition;

final class StorageSchemaCollectionFactory {

  public function create(array $definition): StorageSchemaCollection {
    $definition = new StorageSchemaCollectionDefinition($definition);

    return new StorageSchemaCollection($definition);
  }

}
