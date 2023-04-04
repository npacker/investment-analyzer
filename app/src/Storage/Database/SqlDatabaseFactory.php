<?php

namespace App\Storage\Database;

use App\Settings;
use PDO;

final class SqlDatabaseFactory implements DatabaseFactoryInterface {

  private string $hostname;

  private string $username;

  private string $password;

  private string $database;

  private PDO $handle;

  public function __construct(Settings $settings) {
    $this->hostname = $settings->database['hostname'];
    $this->username = $settings->database['username'];
    $this->password = $settings->database['password'];
    $this->database = $settings->database['database'];
  }

  public function getInstance(): PDO {
    if (!isset($this->handle)) {
      $this->handle = new PDO("mysql:host={$this->hostname};dbname={$this->database}", $this->username, $this->password);

      $this->handle->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
      $this->handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->handle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    return $this->handle;
  }

}
