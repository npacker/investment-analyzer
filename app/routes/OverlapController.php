<?php

namespace App\Route;

use App\Http\Request;
use App\Http\HttpResponse;
use App\Controller\AbstractController;

final class OverlapController extends AbstractController {

  public function view(Request $request) {
    return new HttpResponse($this->app->twig()->render('base.html.twig', [
      'title' => 'Overlap',
      'content' => 'Overlap goes here.',
    ]));
  }

}
