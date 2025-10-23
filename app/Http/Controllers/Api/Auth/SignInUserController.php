<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use App\Actions\Auth\SignInUserAction;
use App\Http\Requests\Auth\StoreSignInRequest;
use Symfony\Component\HttpFoundation\JsonResponse;

final class SignInUserController
{
    public function store(StoreSignInRequest $request, SignInUserAction $action): JsonResponse
    {
        $request->validated();

        $response = $action->handle($request->email, $request->password);

        if ($response === []) {
            return response()->json([
                'message' => 'failed sign in',
                'status' => 'error',
            ], 422);
        }

        return response()->json([
            'data' => $response,
            'status' => 'success',
            'message' => 'Successfully logged in',
        ]);
    }
}
