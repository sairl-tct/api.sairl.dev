<?php

declare(strict_types=1);

use App\Http\Requests\Categories\UpdateCategoryRequest;
use Illuminate\Support\Facades\Validator;

it('fails when name is missing', function (): void {
    $request = new UpdateCategoryRequest();

    $validator = Validator::make([
        // 'name' => 'Tech', // missing on purpose
        'description' => 'Some description',
    ], $request->rules());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('name');
});

it('fails when name is too short', function (): void {
    $request = new UpdateCategoryRequest();

    $validator = Validator::make([
        'name'        => 'Abc', // min:4
        'description' => 'Short name',
    ], $request->rules());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('name');
});

it('fails when description is too long', function (): void {
    $request = new UpdateCategoryRequest();

    $validator = Validator::make([
        'name'        => 'Valid Name',
        'description' => str_repeat('a', 256), // > 255
    ], $request->rules());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('description');
});

it('passes when all fields are valid', function (): void {
    $request = new UpdateCategoryRequest();

    $validator = Validator::make([
        'name'        => 'Valid Name',
        'description' => 'Valid description',
    ], $request->rules());

    expect($validator->fails())->toBeFalse();
});
