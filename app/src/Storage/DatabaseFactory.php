<?php

namespace App\Storage;

use App\Settings;
use PDO;

final class DatabaseFactory {

  private string $hostname;

  private string $username;

  private string $password;

  private string $database;

  private PDO $pdo;

  public function __construct(Settings $settings) {
    $this->hostname = $settings->database['hostname'];
    $this->username = $settings->database['username'];
    $this->password = $settings->database['password'];
    $this->database = $settings->database['database'];
  }

  public function getInstance(): PDO {
    if (!isset($this->pdo)) {
      $this->pdo = new PDO("mysql:host={$this->hostname};dbname={$this->database}", $this->username, $this->password);
    }

    return $this->pdo;
  }

}
