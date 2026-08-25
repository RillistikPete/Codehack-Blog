<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    public function definition(): array
    {
        return ['name' => fake()->unique()->word()];
    }

    public function administrator(): static
    {
        return $this->state(fn () => ['name' => 'administrator']);
    }
}