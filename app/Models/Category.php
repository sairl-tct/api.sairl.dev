<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonInterface;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property-read int $id
 * @property-read string $slug
 * @property-read string $name
 * @property-read string $description
 * @property-read CarbonInterface $created_at
 * @property-read CarbonInterface $updated_at
 */
final class Category extends Model
{
    /**
     * @use HasFactory<CategoryFactory>
     */
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'slug' => 'string',
            'name' => 'string',
            'description' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
