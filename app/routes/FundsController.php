<?php

namespace App\Route;

use App\Http\RequestInterface;
use App\Http\HttpResponse;
use App\Controller\AbstractController;

final class FundsController extends AbstractController {

  public function view(RequestInterface $request) {
    return new HttpResponse($this->render('funds.html.twig', [
      'title' => 'Funds',
    ]));
  }

  public function create(RequestInterface $request) {
    return new HttpResponse($this->render('funds/create.html.twig', [
      'title' => 'Create Fund',
    ]));
  }

}
