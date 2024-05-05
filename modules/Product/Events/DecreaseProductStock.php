<?php

namespace Modules\Product\Events;

use Modules\Order\Checkout\OrderFullfilled;
use Modules\Product\Warehouse\ProductStockManager;

class DecreaseProductStock
{
    public function __construct(protected ProductStockManager $productStockManager)
    {
    }

    public function handle(OrderFullfilled $event): void
    {
        foreach ($event->order->lines as $cartItem) {
            $this->productStockManager->decrement($cartItem->productId, $cartItem->quantity);
        }
    }
}
