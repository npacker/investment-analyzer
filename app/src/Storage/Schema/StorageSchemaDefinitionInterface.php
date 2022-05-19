<?php

namespace App\Storage\Schema;

interface StorageSchemaDefinitionInterface {

  public function name(): string;

  public function class(): string;

}
