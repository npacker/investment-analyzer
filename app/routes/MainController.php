<?php

namespace App\Route;

use App\Http\Request;
use App\Http\HttpResponse;
use App\Controller\AbstractController;

final class MainController extends AbstractController {

  public function handle(Request $request) {
    return new HttpResponse($this->app->twig()->render('base.html.twig', [
      'title' => 'Investments Analyzer',
      'content' => 'Hello World!',
    ]));
  }

}
