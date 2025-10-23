<?php

declare(strict_types=1);

use App\Models\User;

test('to array', function (): void {
    $user = User::factory()->create()->fresh();
    expect(array_keys($user->toArray()))
        ->toBe([
            'id',
            'username',
            'email',
            'email_verified_at',
            'remember_token',
            'created_at',
            'updated_at',
        ]);
});
