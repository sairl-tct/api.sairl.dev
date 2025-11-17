<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\TeamTag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends Factory<TeamTag>
 */
final class TeamTagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
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
