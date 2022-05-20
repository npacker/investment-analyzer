<?php

namespace App\Storage\Sql;

use PDO;

abstract class SqlStorage {

  protected PDO $handle;

  final public function __construct(PDO $handle) {
    $this->handle = $handle;
  }

}
