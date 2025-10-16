<?php

declare(strict_types=1);

namespace App\Http\Requests\Categories;

use Illuminate\Foundation\Http\FormRequest;

final class StoreCategoryRequest extends FormRequest
{
    /**
     * @return array<string, array<int,string>>
     */
    public function rules(): array
    {
        return [
            'slug' => ['required', 'string', 'unique:categories,slug'],
            'name' => ['required', 'string', 'min:4', 'max:50'],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
}
