<?php

namespace App\Model\Schema\Sql;

use App\Storage\Sql\SqlStorage;

final class SqlFundStorageSchema extends SqlStorage {

  public function build() {
    $query = 'CREATE TABLE IF NOT EXISTS
              fund (
                symbol VARCHAR(15) NOT NULL,
                name VARCHAR(255) NOT NULL,
                PRIMARY KEY (symbol)
              )
              ENGINE=InnoDB
              DEFAULT CHARSET=utf8mb4';

    $statement = $this->handle->prepare($query);
    $statement->execute();
  }

}
