<?php

namespace App\Storage\Sql;

use App\Storage\Database\DatabaseFactoryInterface;
use PDO;

abstract class SqlStorage {

  protected PDO $handle;

  final public function __construct(DatabaseFactoryInterface $database_factory) {
    $this->handle = $database_factory->getInstance();
  }

}
