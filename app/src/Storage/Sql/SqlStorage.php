<?php

namespace App\Storage\Sql;

abstract class SqlStorage {

  protected $pdo;

  final public function __construct(\PDO $pdo) {
    $this->pdo = $pdo;
  }

}
