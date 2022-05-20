<?php

namespace App\Storage\Sql\Schema;

final class SqlPortfolioStorageSchema extends SqlStorage {

  public function build() {
    $query = 'CREATE TABLE IF NOT EXISTS
              portfolio (
                id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                name VARCHAR(255) NOT NULL,
                PRIMARY KEY (id)
              )
              ENGINE=InnoDB
              DEFAULT CHARSEt=utf8mb4';

    $statement = $this->handle->prepare($query);
    $statement->execute();
  }

}
