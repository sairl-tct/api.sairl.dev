<?php

declare(strict_types=1);

namespace App\Http\Requests\TeamCategories;

use Illuminate\Foundation\Http\FormRequest;

final class StoreTeamCategoryRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:50', 'unique:team_categories,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
}
