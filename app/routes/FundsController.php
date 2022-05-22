<?php

namespace App\Route;

use App\Container\ContainerInterface;
use App\Controller\AbstractController;
use App\Http\HttpResponse;
use App\Http\RequestInterface;
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
    return new HttpResponse($this->render('funds.html.twig', [
      'title' => 'Funds',
    ]));
  }

  public function createView(RequestInterface $request) {
    return new HttpResponse($this->render('funds/create.html.twig', [
      'title' => 'Create Fund',
    ]));
  }

  public function createSubmit(RequestInterface $request) {
    $this->messenger->set('Created new fund.');

    return new HttpResponse('Redirecting...', HttpResponse::HTTP_FOUND, ['Location' => '/funds/create']);
  }

}
