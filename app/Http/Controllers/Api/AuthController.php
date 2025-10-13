<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Actions\Auth\RegisterAction;
use App\Http\Requests\Auth\StoreRegisterRequest;
use Illuminate\Http\JsonResponse;

final class AuthController
{
    public function register(StoreRegisterRequest $request, RegisterAction $action): JsonResponse
    {
        $request->validated();

        $user = $action->handle($request->username, $request->email, $request->password);

        return response()->json([
            'data' => $user,
            'status' => 'success',
            'message' => 'Successfully registered',
        ], 201);

    }
}
