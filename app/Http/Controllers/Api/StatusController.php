<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Queries\Statuses\GetStatus;
use App\Actions\Queries\Statuses\GetStatuses;
use App\Actions\Statuses\CreateStatus;
use App\Actions\Statuses\DeleteStatus;
use App\Actions\Statuses\UpdateStatus;
use App\Helpers\ApiResponse;
use App\Http\Requests\Statuses\StoreStatusRequest;
use Illuminate\Http\JsonResponse;

final class StatusController
{
    use ApiResponse;

    public function index(GetStatuses $statuses): JsonResponse
    {
        $response = $statuses->handle();
        if ($response->isEmpty()) {
            return $this->notFound('statuses not found');
        }

        return $this->success('retrieved statuses successfully', $response);
    }

    public function show(int $id, GetStatus $status): JsonResponse
    {
        $response = $status->handle($id);

        if (is_null($response)) {
            return $this->notFound('status not found');
        }

        return $this->success('retrieved status successfully', $response);
    }

    public function store(StoreStatusRequest $request, CreateStatus $createStatus): JsonResponse
    {
        $status = $request->validated();
        $response = $createStatus->handle($status);

        return $this->created('status created successfully', $response);

    }

    public function update(int $id, UpdateStatus $updateStatus, StoreStatusRequest $request): JsonResponse
    {
        $status = $request->validated();
        /** @var array{status: string, message: string, code: int, data?: mixed} $response */
        $response = $updateStatus->handle($id, $status);

        return response()->json([
            'status' => $response['status'],
            'message' => $response['message'],
        ], $response['code']);
    }

    public function destroy(int $id, DeleteStatus $deleteStatus): JsonResponse
    {
        $response = $deleteStatus->handle($id);
        if (! $response) {
            return $this->notFound('status not found');
        }

        return $this->success('status deleted successfully');
    }
}
