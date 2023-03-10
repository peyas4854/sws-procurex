<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'        => $this->faker->text(12),
            'description' => $this->faker->text(50),
            'category_code'       => $this->faker->randomFloat(3, 10, 100),
            'created_by'=>1,
        ];
    }
}
