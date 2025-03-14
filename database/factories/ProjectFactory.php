<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'due_date' => $this->faker->optional()->date(),
            'created_by' => User::inRandomOrder()->first()->id ?? User::factory(), // Asegura que siempre tenga un creador
        ];
    }
}
