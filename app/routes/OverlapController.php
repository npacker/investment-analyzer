<?php

namespace App\Route;

use App\Http\RequestInterface;
use App\Controller\RouteController;

final class OverlapController extends RouteController {

  public function view(RequestInterface $request) {
    return $this->response('base', [
      'title' => 'Overlap',
      'content' => 'Overlap goes here.',
    ]);
  }

}
