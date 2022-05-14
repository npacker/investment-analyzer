<?php

namespace App\Storage\Sql\Schema;

final class SqlPortfolioPositionStorageSchema {

  public function build() {
    $query = 'CREATE TABLE IF NOT EXISTS
              portfolio_position (
                portfolio INT(10) UNSIGNED NOT NULL,
                fund VARCHAR(15) NOT NULL,
                weight DECIMAL(12,9) NOT NULL,
                PRIMARY KEY (portfolio, fund)
                CONSTRAINT fk_portfolio_position__portfolio
                  FOREGIN KEY (portfolio) REFERENCES portfolio (id)
                    ON DELETE CASCADE
                    ON UPDATE CASCADE
                  FOREIGN KEY (fund) REFERENCES fund (symbol)
                    ON DELETE CASCADE
                    ON UPDATE CASCADE
              )
              ENGINE=InnoDB
              DEFAULT CHARSET=utf8mb4';

    $this->pdo->query($query);
  }

}
