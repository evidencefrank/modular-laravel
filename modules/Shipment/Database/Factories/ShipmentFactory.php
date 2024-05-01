<?php

namespace Modules\Shipment\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Shipment\Models\Shipment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Shipment\Models\Shipment>
 */
class ShipmentFactory extends Factory
{
    protected $model = Shipment::class;

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
