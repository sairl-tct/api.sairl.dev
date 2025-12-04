<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Queries\Tags\GetTag;
use App\Actions\Queries\Tags\GetTags;
use App\Actions\Tags\CreateTag;
use App\Actions\Tags\DeleteTag;
use App\Actions\Tags\UpdateTag;
use App\Helpers\ApiResponse;
use App\Http\Requests\Tags\StoreTagRequest;
use App\Http\Requests\Tags\UpdateTagRequest;
use Illuminate\Http\JsonResponse;

final class TagController
{
    use ApiResponse;

    public function index(GetTags $getTags): JsonResponse
    {
        $response = $getTags->handle();
        if ($response->isEmpty()) {
            return $this->notFound('Tags not found');
        }

        return $this->success('tags retrieved successfully', $response);
    }

    public function show(int $id, GetTag $getTag): JsonResponse
    {
        $response = $getTag->handle($id);
        if (is_null($response)) {
            return $this->notFound('tag not found');
        }

        return $this->success('tag retrieved successfully', $response);
    }

    public function store(StoreTagRequest $request, CreateTag $createTag): JsonResponse
    {
        $tag = $request->validated();
        $response = $createTag->handle($tag);

        return $this->created('tag created successfully', $response);
    }

    public function update(UpdateTagRequest $request, int $id, UpdateTag $updateTag): JsonResponse
    {
        $tag = $request->validated();
        /** @var array{status: string, message: string, code: int, data?: mixed} $response */
        $response = $updateTag->handle($id, $tag);

        return response()->json([
            'status' => $response['status'],
            'message' => $response['message'],
        ], $response['code']);
    }

    public function destroy(int $id, DeleteTag $deleteTag): JsonResponse
    {
        $response = $deleteTag->handle($id);
        if (! $response) {
            return $this->notFound('tag not found');
        }

        return $this->success('tag deleted successfully');
    }
}
