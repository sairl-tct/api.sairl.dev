<?php

declare(strict_types=1);

namespace App\Http\Requests\Roles;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateRoleRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:50'],
            'description' => ['nullable', 'string', 'min:3', 'max:255'],
        ];
    }
}
