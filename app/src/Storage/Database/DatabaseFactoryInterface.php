<?php

namespace App\Storage\Database;

use PDO;

interface DatabaseFactoryInterface {

  public function getInstance(): PDO;

}
