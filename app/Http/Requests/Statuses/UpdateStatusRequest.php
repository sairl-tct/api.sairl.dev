<?php

declare(strict_types=1);

namespace App\Http\Requests\Statuses;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateStatusRequest extends FormRequest
{
    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:4', 'max:50'],
            'description' => ['nullable', 'string', 'min:3', 'max:255'],
        ];
    }
}
