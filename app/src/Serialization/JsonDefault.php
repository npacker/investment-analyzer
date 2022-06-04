<?php

namespace App\Serialization;

final class JsonDefault implements SerializableInterface, SerializedInterface {

  public function encode($data) {
    $json = json_encode($data);

    if (json_last_error() !== JSON_ERROR_NONE) {
      throw new RuntimeException(json_last_error_msg());
    }

    return $json;
  }

  public function decode($json) {
    $data = json_decode($json);

    if (json_last_error() !== JSON_ERROR_NONE) {
      throw new RuntimeException(json_last_error_msg());
    }

    return $data;
  }

}
