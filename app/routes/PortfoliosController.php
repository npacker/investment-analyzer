<?php

namespace App\Route;

use App\Http\RequestInterface;
use App\Http\HttpResponse;
use App\Controller\AbstractController;

final class PortfoliosController extends AbstractController {

  public function view(RequestInterface $request) {
    return new HttpResponse($this->render('portfolios.html.twig', [
      'title' => 'Portfolios',
      'portfolios' => [],
    ]));
  }

  public function createView(RequestInterface $request) {
    return new HttpResponse($this->render('portfolios/create.html.twig', [
      'title' => 'Create Portfolio',
    ]));
  }

  public function createSubmit(RequestInterface $request) {
    return $this->redirect($this->url('portfolios_view_all'));
  }

}
