<?php

namespace App\Router;

final class PregRoutePattern {

  private $path;

  private $delimiter;

  public function __construct(string $path, string $delimiter = '@') {
    $this->path = $path;
    $this->delimiter = $delimiter;
  }

  public function __toString() {
    $pattern = $this->delimiter . '{[^/]+}' . $this->delimiter;
    $replacement = '([^/]+)';
    $escaped = (string) new PregRouteEscaped($this->path, $this->delimiter);

    return $this->delimiter . '^' . preg_replace($pattern, $replacement, $escaped) . '$' . $this->delimiter;
  }

  public function labels() {
    preg_match_all($this->delimiter . '{([^\/]+)}' . $this->delimiter, $this->path, $labels);

    return array_values(end(array_slice($labels, 1)));
  }

}
