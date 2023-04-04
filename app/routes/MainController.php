<?php

namespace App\Route;

use App\Http\RequestInterface;
use App\Http\HttpResponse;
use App\Controller\RouteController;

final class MainController extends RouteController {

  public function view(RequestInterface $request) {
    return $this->response('base', [
      'title' => 'Investments Analyzer',
      'content' => 'Hello World!',
    ]);
  }

}
