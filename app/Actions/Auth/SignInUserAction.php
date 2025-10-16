<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use SensitiveParameter;

final class SignInUserAction
{
    /**
     * @return array<string, mixed>
     *
     * @throws ConnectionException
     */
    public function handle(
        string $email,
        #[SensitiveParameter] string $password
    ): array {

        if (! (Auth::attempt(['email' => $email, 'password' => $password]))) {
            return [];
        }

        $user = Auth::user();

        assert($user instanceof User);

        $url = config('app.url');

        assert(is_string($url));

        $response = Http::asForm()->post("$url/oauth/token", [
            'grant_type' => 'password',
            'client_id' => config('app.passport.password_client_id'),
            'client_secret' => config('app.passport.password_client_secret'),
            'username' => $email,
            'password' => $password,
            'scope' => '',
        ]);

        if ($response->failed()) {
            return [];
        }

        $data = $response->json();

        assert(is_array($data));

        return [
            'token' => $data['access_token'],
            'refresh_token' => $data['refresh_token'],
            'expires_in' => $data['expires_in'],
            'token_type' => 'Bearer',
            'email' => $user->email,
        ];
    }
}
