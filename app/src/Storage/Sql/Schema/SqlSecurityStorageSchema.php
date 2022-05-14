<?php

namespace App\Storage\Sql\Schema;

final class SqlSecurityStorageSchema extends SqlStorage {

  public function build() {
    $query = 'CREATE TABLE IF NOT EXISTS
              security (
                symbol VARCHAR(15) NOT NULL,
                name VARCHAR(255) NOT NULL,
                PRIMARY KEY (symbol)
              )
              ENGINE=InnoDB
              DEFAULT CHARSET=utf8mb4';

    $this->pdo->query($query);
  }

}
