<?php

namespace Modules\Product\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Product\Models\CartItem;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Product\Models\CartItem>
 */
class CartItemFactory extends Factory
{
    protected $model = CartItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }
}
