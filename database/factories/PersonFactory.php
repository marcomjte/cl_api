<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'note' => fake()->realText(20),
            'date_of_birth' => fake()->dateTimeBetween($startDate = '-10 years', $endDate = 'now', $timezone = null, $format = 'Y-m-d H:i:s', $max = 'now'),
            'url_web_page' => fake()->url(),
            'work_company' => fake()->realText(20)
        ];
    }
}
