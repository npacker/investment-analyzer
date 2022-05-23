<?php

namespace App\Storage\Sql;

use App\Storage\SecurityStorageInterface;

final class SqlSecurityStorage implements SecurityStorageInterface {

  public function find(string $symbol) {
    $query = 'SELECT symbol, name
              FROM security
              WHERE symbol = :symbol';

    $statement = $this->handle->prepare($query);
    $statement->bindParam('symbol', $symbol);
    $statement->execute();

    return $statement->fetch();
  }

  public function create(string $symbol, string $name): int {
    $query = 'INSERT INTO security
              (symbol, name)
              VALUES
              (:symbol, :name)
              ON DUPLICATE KEY UPDATE
              name = :name';

    $statement = $this->handle->prepare($query);
    $statement->bindParam('symbol', $symbol);
    $statement->bindParam('name', $name);
    $statement->execute();

    return $this->handle->lastInsertId();
  }

  public function delete(string $symbol): int {
    $query = 'DELETE FROM security
              WHERE symbol = :symbol';

    $statement = $this->handle->prepare($query);
    $statement->bindParam('symbol', $symbol);
    $statement->execute();

    return $statement->rowCount();
  }

}
