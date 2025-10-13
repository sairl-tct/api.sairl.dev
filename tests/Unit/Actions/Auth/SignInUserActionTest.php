<?php

declare(strict_types=1);

// beforeEach(function () {
//    // Create a user
//    $this->user = User::factory()->create([
//        'username' => 'piko123',
//        'email' => 'piko@example.com',
//        'password' => \Illuminate\Support\Facades\Hash::make('secret123'),
//    ]);
//
//    $this->action = app(SignInUserAction::class);
// });
//
// it('can login with email', function () {
//    $result = $this->action->handle('piko@example.com', 'secret123');
//    expect($result)->toBeTrue();
// });
//
// it('can login with username', function () {
//    $result = $this->action->handle('piko123', 'secret123');
//    expect($result)->toBeTrue();
// });
//
// it('fails login with wrong password', function () {
//    $result = $this->action->handle('piko123', 'wrong_pass');
//    expect($result)->toBeFalse();
// });
//
// it('fails login with unknown email', function () {
//    $result = $this->action->handle('unknown@example.com', 'secret123');
//    expect($result)->toBeFalse();
// });
