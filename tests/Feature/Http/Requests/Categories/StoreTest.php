<?php 
declare(strict_types=1);

use App\Http\Requests\Categories\StoreCategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

it('fails when name is missing', function (): void {
    $request = new StoreCategoryRequest();

    $validator = Validator::make([
        // 'name' => 'Business', // missing name
        'descripttion' => 'All about business',
    ], $request->rules());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('name');
});

it('fails when name is too short', function (): void {
    $request = new StoreCategoryRequest();

    $validator = Validator::make([
        'name' => 'ABC', // too short
        'description' => 'All about business',
    ], $request->rules());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('name');
});

it('fails when name is not unique', function (): void{
    Category::factory()->create([
        'name' => 'Business',
    ]);

    $request = new StoreCategoryRequest();

    $validator = Validator::make([
        'name' => 'Business', // duplicate name
        'description' => 'All about business',
    ], $request->rules());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('name');
});

it('fails when description is too long', function (): void {
    $request = new StoreCategoryRequest();

    $validator = Validator::make([
        'name' => 'Business',
        'description' => str_repeat('a', 256), // > 255
    ], $request->rules());

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors())->toHaveKey('description');
});

it('passes when all fields are valid', function (): void {

    $request = new StoreCategoryRequest();

    $validator = Validator::make([
        'name' => 'Technology', // unique name
        'description' => 'All about technology',
    ], $request->rules());

    expect($validator->passes())->toBeTrue();
});