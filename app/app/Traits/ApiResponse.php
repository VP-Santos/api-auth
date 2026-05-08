<?php

namespace App\Traits;

trait ApiResponse
{
  protected function success(
    string $message,
    mixed $data = null,
    int $status = 200,
  ) {
    $response = [
      'success' => true,
      'message' => $message,
      ...($data !== null ? ['data' => $data] : []),
    ];

    return response()->json($response, $status);
  }

  protected function error(
    string $errorCode,
    mixed $errors = [],
    int $status = 400
  ) {
    $response = [
      'success' => false,
      'error_code' => $errorCode,
      ...($errors !== null ? ['data' => $errors] : []),
    ];
    return response()->json($response, $status);
  }
}
