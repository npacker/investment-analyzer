<?php

namespace App;

use App\AppInterface;
use App\Container\Container;
use App\Container\ContainerDefinition;
use App\Container\ContainerInterface;
use App\EnvironmentInterface;
use App\Router\RouteCollection;
use App\Serialization\YamlSymfony;
use App\Settings;
use App\Stream\LocalReadOnlyFile;

final class Environment implements EnvironmentInterface {

  private $autoloader;

  private string $root;

  public function __construct($autoloader) {
    $this->autoloader = $autoloader;
    $this->root = dirname(__DIR__, 2);
  }

  public function autoloader() {
    return $this->autoloader;
  }

  public function root(): string {
    return $this->root;
  }

  public function bootstrap(): AppInterface {
    ini_set('display_errors', 0);
    ini_set('error_reporting', E_ALL);

    register_shutdown_function([$this, 'fatalErrorHandler']);
    set_error_handler([$this, 'errorHandler']);
    set_exception_handler([$this, 'exceptionHandler']);

    $container = $this->initializeContainer();
    $settings = $this->initializeSettings($container);
    $routes = $this->initializeRoutes($container);
    $app = new App($this->autoloader, $container, $settings, $routes);

    $this->initializeDatabase($container);
    $this->initializeSession($container);
    $this->initializeTemplateEngine($container);

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
        printf('<pre><strong>Fatal error</strong>: %s in %s on line %d</pre>', $error['message'], $error['file'], $error['line']);
        exit();
    }
  }

  public function errorHandler($errno, $errstr, $errfile, $errline): void {
    if ($errno === E_ERROR) {
      throw new \ErrorException(sprintf('%s in %s on line %d', $errstr, $errfile, $errline), 0, $errno, $errfile, $errline);
    }
  }

  public function exceptionHandler(\Throwable $e) {
    printf('<pre><strong>Uncaught exception:</strong> %s on line %d of %s</pre>', $e->getMessage(), $e->getLine(), $e->getFile());
    exit();
  }

  private function cleanAllBuffers(): void {
    while (ob_get_level() != 0) {
      ob_end_clean();
    }
  }

  private function initializeContainer(): Container {
    $yaml = new YamlSymfony();
    $stream = new LocalReadOnlyFile($this->root() . '/app/config/container.yml');
    $definition = new ContainerDefinition($yaml->decode($stream->read()));
    $container = new Container();

    foreach ($definition->services() as $name => $service) {
      $container->setDefinition($name, $service);
    }

    foreach ($definition->parameters() as $name => $parameter) {
      $container->setParameter($name, $parameter);
    }

    $container->set('yaml', $yaml);

    return $container;
  }

  private function initializeSettings(ContainerInterface $container): Settings {
    $yaml = $container->get('yaml');
    $stream = new LocalReadOnlyFile($this->root() . '/app/config/settings.yml');
    $settings = new Settings($yaml->decode($stream->read()));

    $container->set('settings', $settings);

    return $settings;
  }

  private function initializeRoutes(ContainerInterface $container): RouteCollection {
    $yaml = $container->get('yaml');
    $stream = new LocalReadOnlyFile($this->root() . '/app/config/routing.yml');
    $route_collection_factory = $container->get('route_collection_factory');
    $routes = $route_collection_factory->create($yaml->decode($stream->read()));

    $container->set('routes', $routes);

    return $routes;
  }

  private function initializeDatabase(ContainerInterface $container): void {
    $database_factory = $container->get('database_factory');
    $database = $database_factory->getInstance();

    $container->set('database', $database);
  }

  private function initializeSession(ContainerInterface $container): void {
    $session = $container->get('session');

    $session->start();
  }

  private function initializeTemplateEngine(ContainerInterface $container): void {
    $container->setParameter('templates_path', $this->root() . '/app/templates');

    $template_engine_builder = $container->get('template_engine_bootstrap_builder');

    $template_engine_builder->build();
  }

}
