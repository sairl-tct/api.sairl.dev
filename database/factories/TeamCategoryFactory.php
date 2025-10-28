<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\TeamCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends Factory<TeamCategory>
 */
final class TeamCategoryFactory extends Factory
{
    protected $model = TeamCategory::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->text(),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
        ];
    }
}
