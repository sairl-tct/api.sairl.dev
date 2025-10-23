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
        $status = Status::query()->find($id);

        if (is_null($status)) {
            return [
                'message' => 'status not found',
                'status' => 'error',
                'code' => 404,
            ];
        }

        $duplicate = Status::query()
            ->where('name', $data['name'])
            ->whereNot('id', $id)
            ->exists();

        if ($duplicate) {
            return [
                'message' => 'The name has already been taken.',
                'status' => 'error',
                'code' => 422,
            ];
        }

        $status->update($data);

        return [
            'message' => 'update status successfully',
            'status' => 'success',
            'code' => 200,
        ];
    }
}
