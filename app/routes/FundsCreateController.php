<?php

namespace App\Route;

use App\Http\Request;
use App\Http\HttpResponse;
use App\Controller\AbstractController;

final class FundsCreateController extends AbstractController {

  public function handle(Request $request) {
    return new HttpResponse($this->app->twig()->render('funds/create.html.twig', [
      'title' => 'Create Fund',
    ]));
  }

}
