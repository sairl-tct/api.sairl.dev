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
            'name' => ['required', 'string', 'min:4', 'max:50', 'unique:categories,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
}
