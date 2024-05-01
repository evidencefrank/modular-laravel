<?php

namespace Modules\Order\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Order\Models\Order;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Order\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;
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
