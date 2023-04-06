<?php

namespace App\Model\Storage\Sql;

use App\Model\Storage\SecurityStorageInterface;
use App\Storage\Sql\SqlStorage;

final class SqlSecurityStorage extends SqlStorage implements SecurityStorageInterface {

  public function all(): array {
    $query = 'SELECT symbol, name
              FROM security';

    $statement = $this->handle->prepare($query);
    $statement->execute();

    return $statement->fetchAll();
  }

  public function find(string $symbol): array {
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
              (:symbol, :name1)
              ON DUPLICATE KEY UPDATE
              name = :name2';

    $statement = $this->handle->prepare($query);
    $statement->bindParam('symbol', $symbol);
    $statement->bindParam('name1', $name);
    $statement->bindParam('name2', $name);
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
