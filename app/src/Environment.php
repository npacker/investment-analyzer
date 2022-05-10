<?php

namespace App;

use App\App;
use App\Http\HttpRequest;

final class Environment {

  private $autoloader;

  public function __construct($autoloader) {
    $this->autoloader = $autoloader;
  }

  public function bootstrap() {
    ini_set('display_errors', 0);
    ini_set('error_reporting', E_ALL);

    register_shutdown_function([$this, 'fatalErrorHandler']);

    set_error_handler([$this, 'errorHandler']);
    set_exception_handler([$this, 'exeptionHandler']);

    set_include_path(ROOT . DS . 'app');

    require ROOT . DS . 'app' . DS . 'config' . DS . 'settings.php';

    $request = new HttpRequest();
    $twig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader(ROOT . DS . 'app' . DS . 'templates'));
    $app = new App($this->autoloader, $settings, $request, $twig);

    return $app;
  }

  public function fatalErrorHandler() {
    $error = error_get_last();

    switch ($error['type']) {
      case E_COMPILE_ERROR:
      case E_CORE_ERROR:
      case E_ERROR:
      case E_PARSE:
      case E_USER_ERROR:
        $this->cleanAllBuffers();
        printf('<strong>Fatal error</strong>: %s in %s on line %d', $error['message'], $error['file'], $error['line']);
        exit();
    }
  }

  public function errorHandler() {
    if ($errno === E_ERROR) {
      throw new \ErrorException(sprintf('%s in %s on line %d', $errstr, $errfile, $errline), 0, $errno, $errfile, $errline);
    }
  }

  public function exceptionHandler() {
    $this->cleanAllBuffers();
    printf('<strong>Uncaught exception:</strong> %s on line %d of %s', $e->getMessage(), $e->getLine(), $e->getFile());
    exit();
  }

  private function cleanAllBuffers() {
    while (ob_get_level() != 0) {
      ob_end_clean();
    }
  }

}
