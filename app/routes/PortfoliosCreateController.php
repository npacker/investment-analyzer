<?php

namespace App\Route;

use App\Http\Request;
use App\Http\HttpResponse;
use App\Controller\AbstractController;

final class PortfoliosCreateController extends AbstractController {

  public function handle(Request $request) {
    return new HttpResponse($this->app->twig()->render('portfolios/create.html.twig', [
      'title' => 'Create Portfolio',
    ]));
  }

}
