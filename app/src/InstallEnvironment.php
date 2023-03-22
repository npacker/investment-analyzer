<?php

namespace App;

use App\EnvironmentInterface;
use App\Installer;
use App\Serialization\YamlSymfony;
use App\Storage\Schema\StorageSchemaCollection;
use App\Stream\LocalReadOnlyFile;

final class InstallEnvironment implements EnvironmentInterface {

  private EnvironmentInterface $environment;

  public function __construct(EnvironmentInterface $environment) {
    $this->environment = $environment;
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
    $yaml = new YamlSymfony();
    $stream = new LocalReadOnlyFile($this->root() . '/app/config/schema.yml');
    $schema_collection_factory = $container->get('schema_collection_factory');
    $schema = $schema_collection_factory->create($yaml->decode($stream->read()));

    return $schema;
  }

}
