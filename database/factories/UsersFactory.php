<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Users>
 */
class UsersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_user' => $this->faker->name(),
            'birthdate' => $this->faker->dateTimeBetween('-22 years', '-18 years'),
            'email' => $this->faker->email(),
            'position' => $this->faker->randomElement([TEACHER, STUDENT]),
        ];
    }
}
