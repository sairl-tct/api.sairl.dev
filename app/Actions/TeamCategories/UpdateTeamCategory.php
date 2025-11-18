<?php

declare(strict_types=1);

namespace App\Actions\TeamCategories;

use App\Models\TeamCategory;

final class UpdateTeamCategory
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function handle(int $id, array $data): array
    {
        $TeamCategory = TeamCategory::query()->find($id);
        if (is_null($TeamCategory)) {
            return [
                'status' => 'error',
                'message' => 'Team category not found',
                'code' => 404,
            ];
        }

        $duplicate = TeamCategory::query()
            ->where('name', $data['name'])
            ->whereNot('id', $id)
            ->exists();
        if ($duplicate) {
            return [
                'status' => 'error',
                'message' => 'The name is already taken',
                'code' => 422,
            ];
        }
        $TeamCategory->update($data);

        return [
            'status' => 'success',
            'message' => 'Team category updated successfully',
            'code' => 200,
        ];
    }
}
