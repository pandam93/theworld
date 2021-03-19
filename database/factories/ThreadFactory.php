<?php

namespace Database\Factories;

use App\Models\Thread;
use App\Models\User;
use App\Models\Board;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


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
        $title = $this->faker->text(50);
        
        return [
            'slug' => Str::slug($title),
            'title' => $title,
            'body' => $this->faker->text(500),
            'board_id' => Board::all()->random(),
            'user_id'=> User::all()->random()
        ];
    }
}
