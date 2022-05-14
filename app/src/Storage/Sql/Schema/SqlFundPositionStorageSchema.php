<?php

namespace App\Storage\Sql\Schema;

final class SqlFundPositionStorageSchema extends SqlStorage {

  public function build() {
    $query = 'CREATE TABLE IF NOT EXISTS
              fund_position (
                fund VARCHAR(15) NOT NULL,
                security VARCHAR(15) NOT NULL,
                weight DECIMAL(12,9) NOT NULL,
                PRIMARY KEY (fund, security)
                CONSTRIANT fk_fund_position__fund
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

    $this->pdo->query($query);
  }

}
