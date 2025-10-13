<?php

declare(strict_types=1);

it('may be registered', function (): void {
    // Arrange...
    $data = [
        'username' => 'test',
        'email' => 'test@gmail.com',
        'password' => 'test1234',
    ];

    // Act...
    $response = $this->postJson(route('api.v1.auth.register'), $data);

    // Assert...
    expect($response->getStatusCode())->toBe(201);
});
