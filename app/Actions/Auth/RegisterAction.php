<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Models\User;
use SensitiveParameter;

final class RegisterAction
{
    public function handle(string $username, string $email, #[SensitiveParameter] string $password): User
    {
        return User::query()->create([
            'username' => $username,
            'email' => $email,
            'password' => $password,
        ]);
    }
}
