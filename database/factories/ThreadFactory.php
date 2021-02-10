<?php

namespace Database\Factories;

use App\Models\Thread;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThreadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Thread::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'board_id' => 1,
            'user_id' => rand(1, 100),
            'slug' => $this->faker->text(6),
            'title' => $this->faker->text(50),
            'thread_text' => $this->faker->text(500),
        ];
    }
}
