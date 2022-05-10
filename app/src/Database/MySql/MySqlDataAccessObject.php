<?php

namespace App\Database\MySql;

abstract class MySqlDataAccessObject {

  protected $pdo;

  final public function __construct(\PDO $pdo) {
    $this->pdo = $pdo;
  }

}
