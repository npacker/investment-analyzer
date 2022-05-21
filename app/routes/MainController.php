<?php

namespace App\Route;

use App\Http\RequestInterface;
use App\Http\HttpResponse;
use App\Controller\AbstractController;

final class MainController extends AbstractController {

  public function view(RequestInterface $request) {
    return new HttpResponse($this->twig()->render('base.html.twig', [
      'title' => 'Investments Analyzer',
      'content' => 'Hello World!',
    ]));
  }

}
