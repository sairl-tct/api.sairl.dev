<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Queries\TeamTags\GetTeamTag;
use App\Actions\Queries\TeamTags\GetTeamTags;
use App\Actions\TeamTags\CreateTeamTag;
use App\Actions\TeamTags\DeleteTeamTag;
use App\Actions\TeamTags\UpdateTeamTag;
use App\Helpers\ApiResponse;
use App\Http\Requests\TeamTags\StoreTeamTagRequest;
use App\Http\Requests\TeamTags\UpdateTeamTagRequest;
use Illuminate\Http\JsonResponse;

final class TeamTagController {
    use ApiResponse;
    public function index(GetTeamTags $getTeamTags): JsonResponse
    {
        $response = $getTeamTags->handle();
        if ($response->isEmpty()){
            return $this->notFound('team tags not found');
        }
        return $this->success('team tags retrieved successfully', $response);
    }
    public function show(GetTeamTag $getTeamTag, int $id): JsonResponse
    {
        $response = $getTeamTag->handle($id);
        if(is_null($response)){
            return $this->notFound('team tag not found');
        }
        return $this->success('team tag retrieved successfully', $response);
    }
    public function store(StoreTeamTagRequest $request, CreateTeamTag $createTeamTag): JsonResponse
    {
        $TeamTag = $request->validated();
        $response = $createTeamTag->handle($TeamTag);
        return $this->created('team tag created successfully', $response);
    }
    public function update(UpdateTeamTagRequest $request, UpdateTeamTag $updateTeamTag, int $id): JsonResponse
    {
        $TeamTag = $request->validated();
        /** @var array{status: string, message: string, code: int, data?: mixed} $response */
        $response = $updateTeamTag->handle($id, $TeamTag);
        return response()->json([
            'status' => $response['status'],
            'message' => $response['message'],
        ], $response['code']);
    }

    public function destroy(DeleteTeamTag $deleteTeamTag, int $id): JsonResponse
    {
        $response = $deleteTeamTag->handle($id);
        if(!$response){
            return $this->notFound('team tag not found');
        }
        return $this->success('team tag deleted successfully');
    }
}
