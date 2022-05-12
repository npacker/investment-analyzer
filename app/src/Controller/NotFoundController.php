<?php

namespace App\Controller;

use App\Http\Request;
use App\Http\HttpResponse;
use App\Controller\AbstractController;

final class NotFoundController extends AbstractController {

  public function view(Request $request) {
    return new HttpResponse($this->app->twig()->render('404.html.twig', [
      'title' => 'Not Found',
    ]), HttpResponse::HTTP_NOT_FOUND);
  }
}
