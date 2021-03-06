<?php

namespace App;

use App\App;
use App\Container\Container;
use App\Container\ContainerDefinition;
use App\Container\ContainerInterface;
use App\Context;
use App\Http\HttpResponse;
use App\Http\RequestInterface;
use App\Http\ResponseInterface;
use App\Messenger\MessengerInterface;
use App\Render\Twig\BootstrapTwigExtension;
use App\Render\Twig\RuntimeTwigExtension;
use App\Router\RouteCollection;
use App\Serialization\YamlSymfony;
use App\Settings;
use App\Storage\Schema\StorageSchemaCollection;
use App\Stream\LocalReadOnlyFile;
use App\Stream\StreamableInterface;
use App\UrlFactory;
use Twig\Environment as TwigEnvironment;

final class Environment {

  private $autoloader;

  private string $root;

  public function __construct($autoloader) {
    $this->autoloader = $autoloader;
    $this->root = dirname(__DIR__, 2);
  }

  public function bootstrap(): App {
    ini_set('display_errors', 0);
    ini_set('error_reporting', E_ALL);

    register_shutdown_function([$this, 'fatalErrorHandler']);
    set_error_handler([$this, 'errorHandler']);
    set_exception_handler([$this, 'exceptionHandler']);

    $container = $this->initializeContainer();
    $settings = $this->initializeSettings($container);
    $routes = $this->initializeRoutes($container);
    $app = new App($this->autoloader, $container, $settings, $routes);

    $this->initializeTwig($container);
    $this->initializeSession($container);

    return $app;
  }

  public function install(App $app, RequestInterface $request): ResponseInterface {
    $context = new Context($app, $request);
    $url_factory = new UrlFactory($context);
    $twig = $app->container()->get('twig');

    $twig->addExtension(new RuntimeTwigExtension($context, $url_factory));

    $schema_collection = $this->initializeSchema($app->container());

    if ($request->server('REQUEST_METHOD') === 'POST') {
      $messenger = $app->container()->get('messenger');

      try {
        $schema_collection->build();
        $messenger->set('Installation completed successfuly.');

        return new HttpResponse('Redirecting...', HttpResponse::HTTP_FOUND, ['Location' => $url_factory->baseUrl()]);
      }
      catch (\Exception $e) {
        $messenger->setError($e->getMessage());
      }
    }

    $schema_collection_definition = $schema_collection->definition();
    $schema_definitions = $schema_collection_definition->schema();

    return new HttpResponse($twig->render('schema.html.twig', [
      'schema_definitions' => $schema_definitions,
    ]));
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

  public function exceptionHandler(Exception $e) {
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
    $stream = new LocalReadOnlyFile($this->root . '/app/config/container.yml');
    $definition = new ContainerDefinition($yaml->decode($stream->read()));
    $container = new Container();

    foreach ($definition->services() as $name => $service) {
      $container->setDefinition($name, $service);
    }

    foreach ($definition->parameters() as $name => $parameter) {
      $container->setParameter($name, $parameter);
    }

    return $container;
  }

  private function initializeSettings(ContainerInterface $container): Settings {
    $yaml = new YamlSymfony();
    $stream = new LocalReadOnlyFile($this->root . '/app/config/settings.yml');
    $settings = new Settings($yaml->decode($stream->read()));

    $container->set('settings', $settings);

    return $settings;
  }

  private function initializeRoutes(ContainerInterface $container): RouteCollection {
    $yaml = new YamlSymfony();
    $stream = new LocalReadOnlyFile($this->root . '/app/config/routing.yml');
    $route_collection_factory = $container->get('route_collection_factory');
    $router = $route_collection_factory->create($yaml->decode($stream->read()));

    $container->set('router', $router);

    return $router;
  }

  private function initializeSchema(ContainerInterface $container): StorageSchemaCollection {
    $yaml = new YamlSymfony();
    $stream = new LocalReadOnlyFile($this->root . '/app/config/schema.yml');
    $schema_collection_factory = $container->get('schema_collection_factory');
    $schema = $schema_collection_factory->create($yaml->decode($stream->read()));

    return $schema;
  }

  private function initializeTwig(ContainerInterface $container): void {
    $container->setParameter('templates_path', $this->root . '/app/templates');

    $messenger = $container->get('messenger');
    $twig = $container->get('twig');

    $twig->addExtension(new BootstrapTwigExtension($messenger));
  }

  private function initializeSession(ContainerInterface $container): void {
    $session = $container->get('session');

    $session->start();
  }

}
