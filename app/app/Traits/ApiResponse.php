<?php

namespace App\Traits;

trait ApiResponse
{
  protected function success(
    string $message,
    array $data = [],
    int $status = 200,
  ) {
    $response = [
      'success' => true,
      'message' => $message,
      ...(!empty($data) ? ['data' => $data] : []),
    ];

    return response()->json($response, $status);
  }
  protected function error(
    string $message,
    array $errors = [],
    int $status = 400
  ) {
    $response = [
      'success' => false,
      'message' => $message,
      ...(!empty($errors) ? ['data' => $errors] : [])
    ];
    return response()->json($response, $status);
  }
}
