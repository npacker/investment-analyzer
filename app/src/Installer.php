<?php

namespace App;

use App\AppInterface;
use App\Container\ContainerInterface;
use App\Http\RequestInterface;
use App\Http\ResponseInterface;
use App\Render\Twig\RuntimeTwigExtension;
use App\Router\RequestMatchingInterface;
use App\Settings;
use App\Storage\Schema\StorageSchemaCollection;

final class Installer implements AppInterface {

  private AppInterface $app;

  private StorageSchemaCollection $schemaCollection;

  public function __construct(AppInterface $app, StorageSchemaCollection $schema_collection) {
    $this->app = $app;
    $this->schemaCollection = $schema_collection;
  }

  public function autoloader() {
    return $this->app->autoloader();
  }

  public function container(): ContainerInterface {
    return $this->app->container();
  }

  public function settings(): Settings {
    return $this->app->settings();
  }

  public function routes(): RequestMatchingInterface {
    return $this->app->routes();
  }

  public function handle(RequestInterface $request): ResponseInterface {
    $this->container()->set('request', $request);
    $this->initializeTwig();

    $controller = 'App\Controller\InstallController';
    $installer = $controller::create($this->container());

    $installer->setSchemaCollection($this->schemaCollection);

    return $installer->view($request);
  }

  private function initializeTwig() {
    $request = $this->container()->get('request');
    $url_factory = $this->container()->get('url_factory');
    $twig = $this->container()->get('twig');

    $twig->addExtension(new RuntimeTwigExtension($this->settings(), $request, $url_factory));
  }

}
