<?php

namespace Modules\Product\Tests\Product\Models;

use Modules\Product\Models\Product;
use Modules\Product\Tests\ProductTestCase;

class ProductTest extends ProductTestCase
{

    public function test_it_creates_a_product(): void
    {
        $product = new Product();

        $this->assertTrue(true);
    }
}
