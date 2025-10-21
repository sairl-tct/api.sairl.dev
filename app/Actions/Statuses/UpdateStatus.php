<?php

declare(strict_types=1);

namespace App\Actions\Statuses;

use App\Models\Status;

final class UpdateStatus
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function handle(int $id, array $data): array
    {
        $status = Status::query()->where('id', $id)->first();
        if (is_null($status)) {
            return [
                'status' => 'error',
                'message' => 'Status not found.',
                'code' => 404,
            ];
        }

        $duplicate = Status::query()
            ->where('name', $data['name'])
            ->where('id', '!=', $id)
            ->exists();

        if ($duplicate) {
            return [
                'status' => 'error',
                'message' => 'The name has already been taken.',
                'code' => 422,
            ];
        }

        $status->update($data);

        return [
            'status' => 'success',
            'message' => 'update status successfully',
            'code' => 200,
        ];
    }
}
