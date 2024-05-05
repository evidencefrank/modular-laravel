<?php

namespace Modules\Product\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Product\Models\Product;

class ProductFactory extends Factory
{
    protected $model = Product::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'price_in_cents' => $this->faker->randomNumber(4),
            'stock' => $this->faker->randomNumber(2),
        ];
    }
}
