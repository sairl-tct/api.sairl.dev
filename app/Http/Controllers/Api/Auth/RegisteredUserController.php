<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\RegisterUserAction;
use App\Http\Requests\Auth\StoreRegisterRequest;
use Illuminate\Http\JsonResponse;

final class RegisteredUserController
{
    public function store(StoreRegisterRequest $request, RegisterUserAction $action): JsonResponse
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
