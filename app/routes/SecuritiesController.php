<?php

namespace App\Route;

use App\Http\RequestInterface;
use App\Http\HttpResponse;
use App\Controller\AbstractController;

final class SecuritiesController extends AbstractController {

  public function view(RequestInterface $request) {
    return new HttpResponse($this->render('base.html.twig', [
      'title' => 'Securities',
      'content' => 'Securities go here.',
    ]));
  }

}
