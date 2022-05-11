<?php

namespace App\Route;

use App\Http\Request;
use App\Http\HttpResponse;
use App\Controller\AbstractController;

final class PortfoliosController extends AbstractController {

  public function handle(Request $request) {
    return new HttpResponse($this->app->twig()->render('portfolios.html.twig', [
      'title' => 'Portfolios',
      'portfolios' => [],
    ]));
  }

}
