<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    protected $model = \App\Models\Author::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'birth_date' => $this->faker->date(),
            'death_date' => $this->faker->optional(0.3)->date(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
