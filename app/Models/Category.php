<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property string $id
 * @property-read string $name
 * @property-read string|null $description
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 */
final class Category extends Model
{
    /**
     * @use HasFactory<CategoryFactory>
     */
    use HasFactory;

    /**
     * UUID primary key, not auto-increment integer.
     */
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'description',
    ];

    protected static function boot(): void
    {
        parent::boot();

        self::creating(function (Category $model): void {
            // If id is empty, generate a UUID
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'name' => 'string',
            'description' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
