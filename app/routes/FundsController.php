<?php

namespace App\Route;

use App\Container\ContainerInterface;
use App\Controller\AbstractController;
use App\Http\HttpResponse;
use App\Http\RequestInterface;
use App\Messenger\MessengerInterface;
use App\Storage\FundStorageInterface;

final class FundsController extends AbstractController {

  private FundStorageInterface $storage;

  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);

    $instance->setStorage($container->get('fund_storage'));

    return $instance;
  }

  public function setStorage(FundStorageInterface $storage) {
    $this->storage = $storage;
  }

  public function view(RequestInterface $request) {
    $funds = $this->storage->all();

    return new HttpResponse($this->render('funds.html.twig', [
      'title' => 'Funds',
      'funds' => $funds,
    ]));
  }

  public function createView(RequestInterface $request) {
    return new HttpResponse($this->render('funds/create.html.twig', [
      'title' => 'Create Fund',
    ]));
  }

  public function createSubmit(RequestInterface $request) {
    $symbol = $request->post('symbol');
    $name = $request->post('name');

    try {
      $this->storage->create($symbol, $name);
      $this->messenger->set(sprintf("Created new fund <strong>%s</strong>.", $name));
    }
    catch (\Exception $e) {
      $this->messenger->set($e->getMessage(), MessageInterface::TYPE_ERROR);
    }

    return new HttpResponse('Redirecting...', HttpResponse::HTTP_FOUND, ['Location' => '/funds/create']);
  }

  public function editView(RequestInterface $request) {
    $parameters = $this->routeMatch->parameters();
    $symbol = $parameters['symbol'];
    $fund = $this->storage->find($symbol);
    $name = $fund['name'];

    return new HttpResponse($this->render('funds/edit.html.twig', [
      'title' => 'Edit fund ' . $symbol,
      'name' => $name,
    ]));
  }

  public function editSubmit(RequestInterface $request) {
    $parameters = $this->routeMatch->parameters();
    $symbol = $parameters['symbol'];
    $name = $request->post('name');

    try {
      $this->storage->update($symbol, $name);
      $this->messenger->set(sprintf("Updated fund <strong>%s</strong>.", $name));

      return new HttpResponse('Redirecting...', HttpResponse::HTTP_FOUND, ['Location' => '/funds']);
    }
    catch (\Exception $e) {
      $this->messenger->set($e->getMessage(), MessengerInterface::TYPE_ERROR);
    }

    return new HttpResponse($this->render('funds/edit.html.twig', [
      'title' => 'Edit fund ' . $symbol,
      'name' => $name,
    ]));
  }

}
