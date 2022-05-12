<?php

namespace App\Router;

final class PregMatchableRouteEscaped implements RouteEscaped {

  private $path;

  private $delimiter;

  public function __construct(string $path, string $delimiter = '@') {
    $this->path = $path;
    $this->delimiter = $delimiter;
  }

  public function __toString() {
    $pattern = $this->delimiter . '(['. preg_quote('=-+?!$*:<>') . '])' . $this->delimiter;
    $replacement = preg_quote('\\') . '$1';

    return preg_replace($pattern, $replacement, $this->path);
  }

  public function raw() {
    return $this->path;
  }

}