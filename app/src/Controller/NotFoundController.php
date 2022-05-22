<?php

namespace App\Controller;

use App\Http\RequestInterface;
use App\Http\HttpResponse;
use App\Controller\AbstractController;

final class NotFoundController extends AbstractController {

  public function view(RequestInterface $request) {
    return new HttpResponse($this->render('404.html.twig', [
      'title' => 'Not Found',
    ]), HttpResponse::HTTP_NOT_FOUND);
  }

}
