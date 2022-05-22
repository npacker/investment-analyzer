<?php

namespace App\Storage\Sql;

use App\Storage\FundStorageInterface;

final class SqlFundStorage extends SqlStorage implements FundStorageInterface {

  public function create(string $symbol, string $name) {
    $query = 'INSERT INTO fund
              (symbol, name)
              VALUES
              (:symbol, :name)';

    $statement = $this->handle->prepare($query);
    $statement->bindParam('symbol', $symbol);
    $statement->bindParam('name', $name);
    $statement->execute();
  }

  public function delete(string $symbol) {
    $query = 'DELETE FROM fund
              WHERE symbol = :symbol';

    $statement = $this->handle->prepare($query);
    $statement->bindParam('symbol', $symbol);
    $statement->execute();
  }

}
