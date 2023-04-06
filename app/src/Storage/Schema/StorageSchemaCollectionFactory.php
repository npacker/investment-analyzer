<?php

namespace App\Storage\Schema;

use App\Storage\Schema\StorageSchemaCollection;
use App\Storage\Schema\StorageSchemaCollectionDefinition;
use App\Storage\Database\DatabaseFactoryInterface;

final class StorageSchemaCollectionFactory {

  private DatabaseFactoryInterface $factory;

  public function __construct(DatabaseFactoryInterface $factory) {
    $this->factory = $factory;
  }

  public function create(array $definition): StorageSchemaCollection {
    $database = $this->factory->getInstance();
    $definition = new StorageSchemaCollectionDefinition($definition);

    return new StorageSchemaCollection($database, $definition);
  }

}
