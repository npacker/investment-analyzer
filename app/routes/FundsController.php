<?php

namespace App\Route;

use App\Http\Request;
use App\Http\HttpResponse;
use App\Controller\AbstractController;

final class FundsController extends AbstractController {

  public function view(Request $request) {
    return new HttpResponse($this->app->twig()->render('funds.html.twig', [
      'title' => 'Funds',
    ]));
  }

  public function create(Request $request) {
    return new HttpResponse($this->app->twig()->render('funds/create.html.twig', [
      'title' => 'Create Fund',
    ]));
  }

}
