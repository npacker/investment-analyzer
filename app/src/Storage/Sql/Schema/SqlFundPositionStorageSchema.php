<?php

namespace App\Storage\Sql\Schema;

use App\Storage\Sql\SqlStorage;

final class SqlFundPositionStorageSchema extends SqlStorage {

  public function build() {
    $query = 'CREATE TABLE IF NOT EXISTS
              fund_position (
                fund VARCHAR(15) NOT NULL,
                security VARCHAR(15) NOT NULL,
                weight DECIMAL(12,9) NOT NULL,
                PRIMARY KEY (fund, security)
                CONSTRAINT fk_fund_position__fund
                  FOREIGN KEY (fund) REFERENCES fund (symbol)
                  ON DELETE CASCADE
                  ON UPDATE CASCADE
                CONSTRAINT fk_fund_position__security
                  FOREIGN KEY (security) REFERENCES security (symbol)
                  ON DELETE CASCADE
                  ON UPDATE CASCADE
              )
              ENGINE=InnoDB
              DEFAULT CHARSET=utf8mb4';

    $statement = $this->handle->prepare($query);
    $statement->execute();
  }

}
