<?php

namespace App\Storage\Sql;

use App\Storage\FundStorageInterface;

final class SqlFundStorage extends SqlStorage implements FundStorageInterface {

  public function all(): array {
    $query = 'SELECT symbol, name
              FROM fund';

    $statement = $this->handle->prepare($query);
    $statement->execute();

    return $statement->fetchAll();
  }

  public function find(string $symbol) {
    $query = 'SELECT name
              FROM fund
              WHERE symbol = :symbol';

    $statement = $this->handle->prepare($query);
    $statement->bindParam('symbol', $symbol);
    $statement->execute();

    return $statement->fetch();
  }

  public function create(string $symbol, string $name): int {
    $query = 'INSERT INTO fund
              (symbol, name)
              VALUES
              (:symbol, :name)';

    $statement = $this->handle->prepare($query);
    $statement->bindParam('symbol', $symbol);
    $statement->bindParam('name', $name);
    $statement->execute();

    return $this->handle->lastInsertId();
  }

  public function update(string $symbol, string $name): int {
    $query = 'UPDATE fund
              SET name = :name
              WHERE symbol = :symbol';

    $statement = $this->handle->prepare($query);
    $statement->bindParam('name', $name);
    $statement->bindParam('symbol', $symbol);
    $statement->execute();

    return $statement->rowCount();
  }

  public function delete(string $symbol): int {
    $query = 'DELETE FROM fund
              WHERE symbol = :symbol';

    $statement = $this->handle->prepare($query);
    $statement->bindParam('symbol', $symbol);
    $statement->execute();

    return $statement->rowCount();
  }

}
