<?php

namespace Database\Factories\V1;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Models\V1\Businesses;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\V1\Clients>
 */
class ClientsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->name(),
            "email" => $this->faker->email(),
            "password" => Hash::make("testing0000"),
            "business_id" => Businesses::inRandomOrder()->first()->id,
        ];
    }
}
