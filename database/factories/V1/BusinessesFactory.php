<?php

namespace Database\Factories\V1;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Businesses>
 */
class BusinessesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->company(),
            "email" => $this->faker->email(),
            "password" => Hash::make("testing0000"),
        ];
    }
}
