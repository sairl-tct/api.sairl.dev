<?php

declare(strict_types=1);

use App\Models\User;

it('is toArray user data', function (): void {
    $user = User::factory()->create()->fresh();
    expect(array_keys($user->toArray()))
        ->toBe([
            'id',
            'username',
            'email',
            'email_verified_at',
            'created_at',
            'updated_at',
        ]);
});
