<?php

declare(strict_types=1);

use App\Http\Requests\Auth\StoreRegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

it('fails when required fields are missing', function (): void {
    $validate = new StoreRegisterRequest();

    $validator = Validator::make([], $validate->rules());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('username')->toHaveKey('email');
});

it('fails when username is not unique or too long', function (): void {
    $user = User::factory()->create();
    $validate = new StoreRegisterRequest();

    $validator = Validator::make([
        'username' => $user->username,
        'email' => $user->email,
        'password' => $user->password,
    ], $validate->rules());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('username');
});

it('passes when all fields are valid', function (): void {
    $validate = new StoreRegisterRequest();

    $validator = Validator::make([
        'username' => 'test',
        'email' => 'test@gmail.com',
        'password' => 'test1234',
    ], $validate->rules());

    expect($validator->fails())->toBeFalse();
});
