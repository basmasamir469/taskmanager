<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function successResponse(
        mixed $data = null,
        string $message = 'Request completed successfully.',
        int $status = 200,
    ): JsonResponse {
        return response()->json([
            'success' => true,
            'message' => $message,
            'code' => $status,
            'data' => $data,
        ], $status);
    }

    protected function errorResponse(
        string $message = 'The request could not be completed.',
        int $status = 400,
        mixed $errors = null,
    ): JsonResponse {
        $response = [
            'success' => false,
            'message' => $message,
            'code'    => $status
        ];

        if ($errors !== null) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }
}
