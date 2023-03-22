<?php

namespace App;

use App\AppInterface;
use App\Container\ContainerInterface;
use App\Http\RequestInterface;
use App\Http\ResponseInterface;
use App\Render\Twig\RuntimeTwigExtension;
use App\Settings;
use App\Storage\Schema\StorageSchemaCollection;
use App\UrlFactory;

final class Installer implements AppInterface {

  private AppInterface $app;

  private StorageSchemaCollection $schema_collection;

  public function __construct(AppInterface $app, StorageSchemaCollection $schema_collection) {
    $this->app = $app;
    $this->schema_collection = $schema_collection;
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
    $context = new Context($this, $request);
    $url_factory = new UrlFactory($context);

    $this->app->container()->set('context', $context);
    $this->app->container()->set('url_factory', $url_factory);

    $this->initializeTwig();

    if ($request->server('REQUEST_METHOD') === 'POST') {
      $messenger = $this->app->container()->get('messenger');

      try {
        $this->schema->build();
        $messenger->set('Installation completed successfuly.');

        return new HttpResponse('Redirecting...', HttpResponse::HTTP_FOUND, ['Location' => $url_factory->baseUrl()]);
      }
      catch (\Exception $e) {
        $messenger->setError($e->getMessage());
      }
    }

    $schema_collection_definition = $this->schema_collection->definition();
    $schema_definitions = $schema_collection_definition->schema();

    return new HttpResponse($twig->render('schema.html.twig', [
      'schema_definitions' => $schema_definitions,
    ]));
  }

  private function initializeTwig(): void {
    $context = $this->app->container()->get('context');
    $url_factory = $this->app->container()->get('url_factory');
    $twig = $this->app->container()->get('twig');

    $twig->addExtension(new RunTimeTwigExtension($context, $url_factory));
  }

}
