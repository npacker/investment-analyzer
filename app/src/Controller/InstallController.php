<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Http\HttpResponse;
use App\Http\RequestInterface;
use App\Storage\Schema\StorageSchemaCollection;

final class InstallController extends AbstractController {

  private StorageSchemaCollection $schemaCollection;

  public function setSchemaCollection(StorageSchemaCollection $schema_collection) {
    $this->schemaCollection = $schema_collection;
  }

  public function view(RequestInterface $request) {
    if ($request->server('REQUEST_METHOD') === 'POST') {
      try {
        $this->schemaCollection->build();
        $this->messenger->set('Installation completed successfully.');

        return $this->redirect($this->urlFactory->baseUrl());
      }
      catch (\Exception $e) {
        $this->messenger->setError($e->getMessage());
      }
    }

    $schema_collection_definition = $this->schemaCollection->definition();
    $schema_definitions = $schema_collection_definition->schema();

    return new HttpResponse($this->render('schema', [
      'schema_definitions' => $schema_definitions,
    ]));
  }

}
