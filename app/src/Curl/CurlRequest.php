<?php

class CurlRequest {

  private $options;

  public function __construct(CurlOptions $options) {
    $this->options = $options;
  }

  public function send(string $url): string {
    $handle = curl_init($url);

    $this->options->apply($handle);

    $buffer = curl_exec($handle);

    if ($buffer === false) {
      throw new Exception(curl_error($handle));
    }

    curl_close($handle);

    return $buffer;
  }

}
