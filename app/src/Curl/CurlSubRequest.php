<?php

class CurlSubRequest {

  private $handle;

  private $parser;

  public function __construct(string $url, CurlOptions $options, Parser $parser) {
    $this->handle = curl_init($url);
    $this->parser = $parser;

    $options->apply($this->handle);
  }

  public function __destruct() {
    curl_close($this->handle);
  }

  public function handle() {
    return $this->handle;
  }

  public function parse(string $buffer) {
    return $this->parser->parse($buffer);
  }

}
