<?php
namespace Database\Factories;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'post_id'   => Post::factory(),
            'author'    => fake()->name(),
            'email'     => fake()->safeEmail(),
            'body'      => fake()->paragraph(),
            'is_active' => 0,
        ];
    }

    public function approved(): static
    {
        return $this->state(fn () => ['is_active' => 1]);
    }
}