<?php

namespace App\Route;

use App\Http\RequestInterface;
use App\Http\HttpResponse;
use App\Controller\AbstractController;

final class FundsController extends AbstractController {

  public function view(RequestInterface $request) {
    $container = $this->app->container();
    $session = $container->get('session');
    $messenger = $container->get('messenger');
    $messenger->set('Hello World');
    return new HttpResponse($this->app->twig()->render('funds.html.twig', [
      'title' => 'Funds',
    ]));
  }

  public function create(RequestInterface $request) {
    return new HttpResponse($this->app->twig()->render('funds/create.html.twig', [
      'title' => 'Create Fund',
    ]));
  }

}
