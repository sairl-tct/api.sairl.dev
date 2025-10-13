<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use SensitiveParameter;

final class SignInUserAction
{
    public function handle(string $login, #[SensitiveParameter] string $password): void
    {
        //        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        //
        //        if (!(Auth::attempt([$field => $login, 'password' => $password]))) {
        //            return false;
        //        }
        //        $user = Auth::user();
        //
        //        return true;
    }
}
