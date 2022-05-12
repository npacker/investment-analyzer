<?php

namespace App;

use App\App;
use App\Router\HttpRoute;
use App\Router\PregMatchableRoute;
use App\Router\PregMatchableRouteEscaped;
use App\Router\PregMatchableRoutePattern;
use App\Router\RouteCollection;
use App\Serialization\Yaml;
use App\Settings;
use App\Stream\LocalReadOnlyFile;

final class Environment {

  private $autoloader;

  private $root;

  public function __construct($autoloader) {
    $this->autoloader = $autoloader;
    $this->root = $this->root();
  }

  public function bootstrap() {
    ini_set('display_errors', 0);
    ini_set('error_reporting', E_ALL);

    register_shutdown_function([$this, 'fatalErrorHandler']);
    set_error_handler([$this, 'errorHandler']);
    set_exception_handler([$this, 'exeptionHandler']);

    $this->autoloader->addPsr4('App\\Route\\', $this->root . '/app/routes');

    $settings = $this->initializeSettings();
    $routes = $this->initializeRoutes();
    $twig = $this->initializeTwig();
    $app = new App($this->autoloader, $settings, $routes, $twig);

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
        printf('<pre><strong>Fatal error</strong>: %s in %s on line %d</pre>', $error['message'], $error['file'], $error['line']);
        exit();
    }
  }

  public function errorHandler($errno, $errstr, $errfile, $errline) {
    if ($errno === E_ERROR) {
      throw new \ErrorException(sprintf('%s in %s on line %d', $errstr, $errfile, $errline), 0, $errno, $errfile, $errline);
    }
  }

  public function exceptionHandler(Exception $e) {
    $this->cleanAllBuffers();
    printf('<pre><strong>Uncaught exception:</strong> %s on line %d of %s</pre>', $e->getMessage(), $e->getLine(), $e->getFile());
    exit();
  }

  private function cleanAllBuffers() {
    while (ob_get_level() != 0) {
      ob_end_clean();
    }
  }

  private function initializeSettings() {
    $stream = new LocalReadOnlyFile($this->root . '/app/config/settings.yml');
    $yaml = new Yaml($stream->read());

    return new Settings($yaml->decode());
  }

  private function initializeRoutes() {
    $stream = new LocalReadOnlyFile($this->root . '/app/config/routing.yml');
    $yaml = new Yaml($stream->read());
    $routes = [];

    foreach ($yaml->decode() as $name => $parameters) {
      extract($parameters);

      $pattern = new PregMatchableRoutePattern(new PregMatchableRouteEscaped($path));
      $routes[] = new HttpRoute(new PregMatchableRoute($pattern, $controller, $action), $methods ?? ['GET']);
    }

    return new RouteCollection(...$routes);
  }

  private function initializeTwig() {
    $loader = new \Twig\Loader\FilesystemLoader($this->root . '/app/templates');

    return new \Twig\Environment($loader);
  }

  private function root() {
    return dirname(__DIR__, 2);
  }

}
