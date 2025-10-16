<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use SensitiveParameter;

final class RegisterUserAction
{
    public function handle(string $username, string $email, #[SensitiveParameter] string $password): User
    {
        $user = User::query()->create([
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        event(new Registered($user));

        return $user;
    }
}
