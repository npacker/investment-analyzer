<?php

namespace App;

use App\App;
use App\Http\HttpRequest;

final class Environment {

  public function bootstrap() {
    ini_set('display_errors', 0);
    ini_set('error_reporting', E_ALL);

    register_shutdown_function([$this, 'fatalErrorHandler']);

    set_error_handler([$this, 'errorHandler']);
    set_exception_handler([$this, 'exeptionHandler']);

    set_include_path(ROOT . DS . 'app');

    spl_autoload_register([$this, 'autoloader']);

    require ROOT . DS . 'vendor' . DS . 'autoload.php';
    require ROOT . DS . 'app' . DS . 'config' . DS . 'settings.php';

    $app = new App($settings, new HttpRequest(), new \Twig\Environment(new \Twig\Loader\FilesystemLoader(ROOT . DS . 'app' . DS . 'templates')));

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

  public function autoloader(string $class) {
    static $classes = array();

    if (isset($classes[$class])) {
      return;
    }

    $namespace = __NAMESPACE__;
    $class_path = str_replace('\\', DS, $class);

    if (substr($class_path, 0, strlen($namespace)) === $namespace) {
      $class_path = substr($class_path, strlen($namespace . DS));
    }

    $file_path = ROOT . DS . 'app' . DS . 'src' . DS . $class_path . '.php';

    if (file_exists($file_path)) {
      $classes[$class] = $file_path;
      require $file_path;
    }
  }

  private function cleanAllBuffers() {
    while (ob_get_level() != 0) {
      ob_end_clean();
    }
  }

}

