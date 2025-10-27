<?php

declare(strict_types=1);

namespace App\Http\Requests\TeamTags;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateTeamTagRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string','min:3', 'max:50'],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
}
