<?php

declare(strict_types=1);

namespace App\Http\Requests\Tags;

use Illuminate\Foundation\Http\FormRequest;

final class StoreTagRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:4', 'max:50', 'unique:tags,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
}
