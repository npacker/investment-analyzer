<?php

namespace App\Storage\Sql;

use PDO;

abstract class SqlStorage {

  protected $pdo;

  final public function __construct(PDO $pdo) {
    $this->pdo = $pdo;
  }

}
