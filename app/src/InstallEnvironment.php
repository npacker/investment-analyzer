<?php

namespace App;

use App\Container\ContainerInterface;
use App\EnvironmentInterface;
use App\Installer;
use App\Storage\Schema\StorageSchemaCollection;
use App\Stream\LocalReadOnlyFile;

final class InstallEnvironment implements EnvironmentInterface {

  private EnvironmentInterface $environment;

  public function __construct(EnvironmentInterface $environment) {
    $this->environment = $environment;
  }

  public function autoloader() {
    return $this->environment->autoloader();
  }

  public function root(): string {
    return $this->environment->root();
  }

  public function bootstrap(): AppInterface {
    $app = $this->environment->bootstrap();
    $schema = $this->initializeSchema($app->container());

    return new Installer($app, $schema);
  }

  private function initializeSchema(ContainerInterface $container): StorageSchemaCollection {
    $yaml = $container->get('yaml');
    $stream = new LocalReadOnlyFile($this->root() . '/app/config/schema.yml');
    $schema_collection_factory = $container->get('schema_collection_factory');
    $schema = $schema_collection_factory->create($yaml->decode($stream->read()));

    return $schema;
  }

}
