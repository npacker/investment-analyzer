<?php

namespace App\Storage\Sql;

use App\Storage\PortfolioStorageInterface;

final class SqlPortfolioStorage extends SqlStorage implements PortfolioStorageInterface {

  public function all(): array {
    $query = 'SELECT id, name
              FROM portfolio';

    $statement = $this->handle->prepare($query);
    $statement->execute();

    return $statement->fetchAll();
  }

  public function find(int $id) {
    $query = 'SELECT name
              FROM portfolio
              WHERE id = :id';

    $statement = $this->handle->prepare($query);
    $statement->bindParam('id', $id);
    $statement->execute();

    return $statement->fetch();
  }

  public function create(string $name): string {
    $query = 'INSERT INTO portfolio
              (name)
              VALUES
              (:name)';

    $statement = $this->handle->prepare($query);
    $statement->bindParam('name', $name);
    $statement->execute();

    return $this->handle->lastInsertId();
  }

  public function update(int $id, string $name): int {
    $query = 'UPDATE portfolio
              SET name = :name
              WHERE id = :id';

    $statement = $this->handle->prepare($query);
    $statement->bindParam('name', $name);
    $statement->bindParam('id', $id);
    $statement->execute();

    return $statement->rowCount();
  }

  public function delete(int $id): int {
    $query = 'DELETE from portfolio
              WHERE id = :id';

    $statement = $this->handle->prepare($query);
    $statement->bindParam('id', $id);
    $statement->execute();

    return $statement->rowCount();
  }

}
