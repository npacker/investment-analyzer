<?php

namespace App;

use App\App;
use App\Container\Container;
use App\Container\ContainerDefinition;
use App\Container\ContainerInterface;
use App\Serialization\YamlSymfony;
use App\Settings;
use App\Stream\LocalReadOnlyFile;
use App\Stream\StreamableInterface;

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

    $container = $this->initializeContainer();
    $settings = $this->initializeSettings($container);
    $routes = $this->initializeRoutes($container);
    $twig = $this->initializeTwig($container);
    $app = new App($this->autoloader, $container, $settings, $routes, $twig);

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

  private function root() {
    return dirname(__DIR__, 2);
  }

  private function loadContainerDefinition(ContainerInterface $container, StreamableInterface $stream) {
    $yaml = new YamlSymfony();
    $definition = new ContainerDefinition($yaml->decode($stream->read()));

    foreach ($definition->services() as $name => $service) {
      $container->setDefinition($name, $service);
    }

    foreach ($definition->parameters() as $name => $parameter) {
      $container->setParameter($name, $parameter);
    }
  }

  private function initializeContainer() {
    $container = new Container();
    $stream = new LocalReadOnlyFile($this->root . '/app/config/container.yml');

    $this->loadContainerDefinition($container, $stream);

    return $container;
  }

  private function initializeSettings(ContainerInterface $container) {
    $yaml = new YamlSymfony();
    $stream = new LocalReadOnlyFile($this->root . '/app/config/settings.yml');
    $settings = new Settings($yaml->decode($stream->read()));

    $container->set('settings', $settings);

    return $settings;
  }

  private function initializeRoutes(ContainerInterface $container) {
    $yaml = new YamlSymfony();
    $stream = new LocalReadOnlyFile($this->root . '/app/config/routing.yml');
    $route_collection_factory = $container->get('route_collection_factory');
    $router = $route_collection_factory->create($yaml->decode($stream->read()));

    $container->set('router', $router);

    return $router;
  }

  private function initializeTwig(ContainerInterface $container) {
    $container->setParameter('templates_path', $this->root . '/app/templates');

    return $container->get('twig_environment');
  }

}
