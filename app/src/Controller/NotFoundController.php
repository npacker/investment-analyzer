<?php

namespace App\Controller;

use App\Controller\AbstractController;
use App\Http\HttpResponse;
use App\Http\RequestInterface;

final class NotFoundController extends AbstractController {

  public function view(RequestInterface $request) {
    return new HttpResponse($this->render('404', [
      'title' => 'Not Found',
    ]), HttpResponse::HTTP_NOT_FOUND);
  }

}
