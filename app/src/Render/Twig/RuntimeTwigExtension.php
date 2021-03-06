<?php

namespace App\Render\Twig;

use App\Context;
use App\UrlFactory;
use Twig\Extension\AbstractExtension as TwigAbstractExtension;
use Twig\Extension\GlobalsInterface as TwigGlobalsInterface;
use Twig\TwigFunction;

final class RuntimeTwigExtension extends TwigAbstractExtension implements TwigGlobalsInterface {

  private Context $context;

  private UrlFactory $urlFactory;

  public function __construct(Context $context, UrlFactory $url_factory) {
    $this->context = $context;
    $this->urlFactory = $url_factory;
  }

  public function getGlobals(): array {
    return [
      'app' => $this->context,
    ];
  }

  public function getFunctions(): array {
    return [
      new TwigFunction('url', [$this->urlFactory, 'urlFromRoute']),
      new TwigFunction('urlFromPath', [$this->urlFactory, 'urlFromPath']),
      new TwigFunction('baseUrl', [$this->urlFactory, 'baseUrl']),
    ];
  }

}
