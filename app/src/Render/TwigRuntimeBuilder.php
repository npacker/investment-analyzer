<?php

namespace App\Render;

use App\Http\RequestInterface;
use App\Render\Twig\RuntimeTwigExtension;
use App\UrlFactory;
use Twig\Environment as TwigEnvironment;

final class TwigRuntimeBuilder implements TemplateEngineBuilderInterface {

  private RequestInterface $request;

  private UrlFactory $urlFactory;

  public function __construct(TwigEnvironment $twig, RequestInterface $request, UrlFactory $url_factory) {
    $this->twig = $twig;
    $this->request = $request;
    $this->urlFactory = $url_factory;
  }

  public function build() {
    $this->twig->addExtension(new RuntimeTwigExtension($this->request, $this->urlFactory));
  }

}
