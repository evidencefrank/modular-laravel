<?php

namespace Modules\Product\Tests\Product\Models;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Modules\Product\Database\Factories\ProductFactory;
use Modules\Product\Models\Product;
use Modules\Product\Tests\ProductTestCase;

class ProductTest extends ProductTestCase
{
    use DatabaseMigrations;

    public function test_it_creates_a_product(): void
    {
        $product = Product::factory()->create();

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => $product->name,
            'price_in_cents' => $product->price_in_cents,
            'stock' => $product->stock,
        ]);
    }
}
