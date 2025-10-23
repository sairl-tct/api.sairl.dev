<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function success(string $message, mixed $data = null): JsonResponse {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ],200);
    }

    protected function created(string $message, mixed $data = null): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], 201);
    }


    protected function notFound(string $message = 'Resource not found'): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], 404);
    }
}
