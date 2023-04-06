<?php

namespace App;

use App\AbstractAppDectorator;
use App\AppInterface;
use App\Http\RequestInterface;
use App\Http\ResponseInterface;
use App\Render\TemplateInitializationTrait;
use App\Storage\Schema\StorageSchemaCollection;

final class Installer extends AbstractAppDecorator {

  use TemplateInitializationTrait;

  private StorageSchemaCollection $schemaCollection;

  public function __construct(AppInterface $app, StorageSchemaCollection $schema_collection) {
    $this->app = $app;
    $this->schemaCollection = $schema_collection;
  }

  public function handle(RequestInterface $request): ResponseInterface {
    $this->container()->set('request', $request);

    $controller = 'App\Controller\InstallController';
    $installer = $controller::create($this->container());

    $installer->setSchemaCollection($this->schemaCollection);
    $this->initializeTemplateEngine();

    return $installer->view($request);
  }

}
