<?php

namespace App\Model\Storage\Sql;

use App\Model\Storage\FundPositionStorageInterface;
use App\Storage\Sql\SqlStorage;

final class SqlFundPositionStorage extends SqlStorage implements FundPositionStorageInterface {

  public function all(): array {
    $query = 'SELECT fund, security, weight
              FROM fund_position';

    $statement = $this->handle->prepare($query);
    $statement->execute();

    return $statement->fetchAll();
  }

  public function find(string $fund) {
    $query = 'SELECT
                fund_position.security AS security,
                fund_position.weight AS weight,
                security.name AS name
              FROM
                fund_position,
                security
              WHERE
                fund_position.security = security.symbol
              AND
                fund_position.fund = :fund
              ORDER BY
                weight DESC';

    $statement = $this->handle->prepare($query);
    $statement->bindParam('fund', $fund);
    $statement->execute();

    return $statement->fetchAll();
  }

  public function create(string $fund, string $security, string $weight): int {
    $query = 'INSERT INTO fund_position
              (fund, security, weight)
              VALUES
              (:fund, :security, :weight1)
              ON DUPLICATE KEY UPDATE
              weight = :weight2';

    $statement = $this->handle->prepare($query);
    $statement->bindParam('fund', $fund);
    $statement->bindParam('security', $security);
    $statement->bindParam('weight1', $weight);
    $statement->bindParam('weight2', $weight);
    $statement->execute();

    return $this->handle->lastInsertId();
  }

  public function delete(string $fund, string $security): int {
    $query = 'DELETE FROM fund_position
              WHERE (fund, security) = (:fund, :security)';

    $statement = $this->handle->prepare($query);
    $statement->bindParam('fund', $fund);
    $statement->bindParam('security', $security);
    $statement->execute();

    return $statement->rowCount();
  }

  public function deleteByFund(string $fund): int {
    $query = 'DELETE FROM fund_position
              WHERE fund = :fund';

    $statement = $this->handle->prepare($query);
    $statement->bindParam('fund', $fund);
    $statement->execute();

    return $statement->rowCount();
  }

}
