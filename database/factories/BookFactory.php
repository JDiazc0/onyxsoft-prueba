<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    protected $model = \App\Models\Book::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'genre' => $this->faker->randomElement(['fiction', 'non-fiction', 'biography', 'science fiction']),
            'published_date' => $this->faker->date,
            'available' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
