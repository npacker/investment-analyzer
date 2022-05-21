<?php

namespace App\Route;

use App\Http\RequestInterface;
use App\Http\HttpResponse;
use App\Controller\AbstractController;

final class PortfoliosController extends AbstractController {

  public function view(RequestInterface $request) {
    return new HttpResponse($this->twig()->render('portfolios.html.twig', [
      'title' => 'Portfolios',
      'portfolios' => [],
    ]));
  }

  public function create(RequestInterface $request) {
    return new HttpResponse($this->twig()->render('portfolios/create.html.twig', [
      'title' => 'Create Portfolio',
    ]));
  }

}
