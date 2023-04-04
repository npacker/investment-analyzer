<?php

namespace App\Route;

use App\Http\RequestInterface;
use App\Http\HttpResponse;
use App\Controller\RouteController;

final class OverlapController extends RouteController {

  public function view(RequestInterface $request) {
    return new HttpResponse($this->render('base', [
      'title' => 'Overlap',
      'content' => 'Overlap goes here.',
    ]));
  }

}
