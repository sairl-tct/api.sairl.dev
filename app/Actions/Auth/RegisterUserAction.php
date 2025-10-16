<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use SensitiveParameter;

final class RegisterUserAction
{
    public function handle(string $username, string $email, #[SensitiveParameter] string $password): User
    {
        return User::query()->create([
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
    }
}
