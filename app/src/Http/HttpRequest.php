<?php

namespace App\Http;

use App\Http\EmptyRequest;

final class HttpRequest extends EmptyRequest {

  public function __construct() {
    $headers = array_change_key_case(apache_request_headers() ?? []);
    $get = filter_input_array(INPUT_GET) ?? [];
    $post = filter_input_array(INPUT_POST) ?? [];
    $server = filter_input_array(INPUT_SERVER) ?? [];
    $cookie = filter_input_array(INPUT_COOKIE) ?? [];
    $files = $_FILES ?? [];
    $path = strtok($server['REQUEST_URI'], '?');

    parent::__construct($headers, $get, $post, $server, $cookie, $files, $path);
  }

}
