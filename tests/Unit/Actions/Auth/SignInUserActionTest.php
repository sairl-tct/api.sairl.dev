<?php

declare(strict_types=1);

use App\Actions\Auth\SignInUserAction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

beforeEach(function (): void {
    // Set up Passport configuration
    Config::set('app.url', 'http://example.com');
    Config::set('app.passport.password_client_id', 'test-client-id');
    Config::set('app.passport.password_client_secret', 'test-client-secret');
});

it('successfully signs in a user and returns tokens', function (): void {
    // Arrange: Create a user and mock successful authentication
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    Auth::shouldReceive('attempt')
        ->once()
        ->with(['email' => 'test@example.com', 'password' => 'password123'])
        ->andReturn(true);

    Auth::shouldReceive('user')
        ->once()
        ->andReturn($user);

    // Mock the HTTP request to the OAuth token endpoint
    Http::fake([
        'http://example.com/oauth/token' => Http::response([
            'access_token' => 'mock-access-token',
            'refresh_token' => 'mock-refresh-token',
            'expires_in' => 3600,
        ], 200),
    ]);

    // Act: Call the action
    $action = app(SignInUserAction::class);
    $result = $action->handle('test@example.com', 'password123');

    // Assert: Check the response structure
    expect($result)->toBeArray()
        ->toHaveKeys(['token', 'refresh_token', 'expires_in', 'token_type', 'email'])
        ->and($result['token'])->toBe('mock-access-token')
        ->and($result['refresh_token'])->toBe('mock-refresh-token')
        ->and($result['expires_in'])->toBe(3600)
        ->and($result['token_type'])->toBe('Bearer')
        ->and($result['email'])->toBe('test@example.com');
});

it('returns an empty array when authentication fails', function (): void {
    // Arrange: Mock failed authentication
    Auth::shouldReceive('attempt')
        ->once()
        ->with(['email' => 'test@example.com', 'password' => 'wrong-password'])
        ->andReturn(false);

    // Act: Call the action
    $action = app(SignInUserAction::class);
    $result = $action->handle('test@example.com', 'wrong-password');

    // Assert: Expect an empty array
    expect($result)->toBeArray()
        ->toBeEmpty();
});

it('fails assertion when user is not an instance of User', function (): void {
    // Arrange: Mock successful authentication but return null for user
    Auth::shouldReceive('attempt')
        ->once()
        ->with(['email' => 'test@example.com', 'password' => 'password123'])
        ->andReturn(true);

    Auth::shouldReceive('user')
        ->once()
        ->andReturn(null);

    // Act & Assert: Expect an assertion failure
    $action = app(SignInUserAction::class);
    expect(fn () => $action->handle('test@example.com', 'password123'))
        ->toThrow(AssertionError::class);
});

it('fails assertion when response data is not an array', function (): void {
    // Arrange: Create a user and mock successful authentication
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password123'),
    ]);

    Auth::shouldReceive('attempt')
        ->once()
        ->with(['email' => 'test@example.com', 'password' => 'password123'])
        ->andReturn(true);

    Auth::shouldReceive('user')
        ->once()
        ->andReturn($user);

    // Mock an invalid response (non-array)
    Http::fake([
        'http://example.com/oauth/token' => Http::response('invalid', 200),
    ]);

    // Act & Assert: Expect an assertion failure
    $action = app(SignInUserAction::class);
    expect(fn () => $action->handle('test@example.com', 'password123'))
        ->toThrow(AssertionError::class);
});
