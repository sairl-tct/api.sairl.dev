<?php

declare(strict_types=1);

namespace App\Actions\Tags;

use App\Models\Tag;

final class UpdateTag
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function handle(int $id, array $data): array
    {
        $tag = Tag::query()->find($id);
        if ($tag === null) {
            return [
                'status' => 'error',
                'message' => 'Tag not found',
                'code' => 404,
            ];
        }

        $duplicate = Tag::query()
            ->where('name', $data['name'])
            ->whereNot('id', $id)
            ->exists();
        if ($duplicate) {
            return [
                'status' => 'error',
                'message' => 'The name has already been taken',
                'code' => 422,
            ];
        }
        $tag->update($data);

        return [
            'status' => 'success',
            'message' => 'Tag updated successfully',
            'code' => 200,
        ];
    }
}
