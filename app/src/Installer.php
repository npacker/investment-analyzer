<?php

namespace App;

use App\AppInterface;
use App\Container\ContainerInterface;
use App\Http\RequestInterface;
use App\Http\ResponseInterface;
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
    $this->initializeTemplateEngine();

    $controller = 'App\Controller\InstallController';
    $installer = $controller::create($this->container());

    $installer->setSchemaCollection($this->schemaCollection);

    return $installer->view($request);
  }

  private function initializeTemplateEngine(): void {
    $template_engine_builder = $this->container()->get('template_engine_runtime_builder');

    $template_engine_builder->build();
  }

}
