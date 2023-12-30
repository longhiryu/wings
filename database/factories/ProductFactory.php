<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'price' => $this->faker->randomNumber(6),
            'special_price' => $this->faker->randomNumber(6),
            'price' => $this->faker->randomNumber(6),
            'selling_price' => $this->faker->randomNumber(6),
            'sku' => $this->faker->unixTime(),
            'qty' => $this->faker->randomNumber(2),
            'in_stock' => rand(0,1),
            'is_active' => rand(0,1),
        ];
    }
}
