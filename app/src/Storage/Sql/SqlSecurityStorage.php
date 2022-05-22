<?php

namespace App\Storage\Sql;

use App\Storage\SecurityStorageInterface;

final class SqlSecurityStorage implements SecurityStorageInterface {

  public function create(string $symbol, string $name) {
    $query = 'INSERT INTO security
              (symbol, name)
              VALUES
              (:symbol, :name)';

    $statement = $this->handle->prepare($query);
    $statement->bindParam('symbol', $symbol);
    $statement->bindParam('name', $name);
    $statement->execute();
  }

  public function delete(string $symbol) {
    $query = 'DELETE FROM security
              WHERE symbol = :symbol';

    $statement = $this->handle->prepare($query);
    $statement->bindParam('symbol', $symbol);
    $statement->execute();
  }

}
