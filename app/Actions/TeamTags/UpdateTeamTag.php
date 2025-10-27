<?php

declare(strict_types=1);

namespace App\Actions\TeamTags;

use App\Models\TeamTag;

final class UpdateTeamTag {
    public function handle(int $id, array $data): array
    {
        $TeamTag = TeamTag::query()->find($id);

        if (is_null($TeamTag)) {
            return [
                'status' => 'error',
                'message' => 'Team tag not found',
                'code' => 404,
            ];
        }

        $duplicate = TeamTag::query()
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
        $TeamTag->update($data);
        return [
            'status' => 'success',
            'message' => 'Team tag successfully updated',
            'code' => 200,
        ];
    }
}
