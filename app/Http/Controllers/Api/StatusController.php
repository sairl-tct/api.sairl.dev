<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Queries\Statuses\GetStatus;
use App\Actions\Queries\Statuses\GetStatuses;
use App\Actions\Statuses\CreateStatus;
use App\Http\Requests\Statuses\StoreStatusRequest;
use Illuminate\Http\JsonResponse;

final class StatusController
{
    public function index(GetStatuses $statuses): JsonResponse
    {
        $response = $statuses->handle();
        if ($response->isEmpty()) {
            return response()->json([
                'message' => 'status not found',
                'status' => 'error',
            ], 422);
        }

        return response()->json([
            'data' => $response,
            'message' => 'retrieved statuses successfully',
            'status' => 'success',
        ]);
    }

    public function show(int $id, GetStatus $status): JsonResponse
    {
        $response = $status->handle($id);

        if (is_null($response)) {
            return response()->json([
                'message' => 'status not found',
                'status' => 'error',
            ],422);
        }

        return response()->json([
            'data' => $response,
            'message' => 'retrieved status successfully',
            'status' => 'success',
        ]);
    }

    public function store(StoreStatusRequest $request, CreateStatus $createStatus): JsonResponse
    {
        $status = $request->validated();
        $response = $createStatus->handle($status);

        return response()->json([
            'data' => $response,
            'message' => 'create status success',
            'status' => 'success',
        ], 201);

    }
}
