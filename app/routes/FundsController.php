<?php

namespace App\Route;

use App\Http\RequestInterface;
use App\Http\HttpResponse;
use App\Controller\AbstractController;

final class FundsController extends AbstractController {

  public function view(RequestInterface $request) {
    $session = $this->container->get('session');
    $messenger = $this->container->get('messenger');
    $messenger->set('Hello World');
    return new HttpResponse($this->twig()->render('funds.html.twig', [
      'title' => 'Funds',
    ]));
  }

  public function create(RequestInterface $request) {
    return new HttpResponse($this->twig()->render('funds/create.html.twig', [
      'title' => 'Create Fund',
    ]));
  }

}
