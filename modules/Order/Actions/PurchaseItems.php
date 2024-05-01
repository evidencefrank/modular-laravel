<?php

namespace Modules\Order\Actions;

use Illuminate\Database\DatabaseManager;
use Modules\Order\Models\Order;
use Modules\Payment\Actions\CreateActionsForOrder;
use Modules\Payment\PayBuddy;
use Modules\Product\CartItem;
use Modules\Product\CartItemCollection;
use Modules\Product\Warehouse\ProductStockManager;

class PurchaseItems
{
    public function __construct(
        protected ProductStockManager $productStockManager,
        protected CreateActionsForOrder $createActionsForOrder,
        protected DatabaseManager $databaseManager
    )
    {}

    /**
     * @param CartItemCollection $items
     * @param PayBuddy $paymentProvider
     * @param string $paymentToken
     * @param int $userId
     * @return Order
     * @throws \Throwable
     */
    public function handle(CartItemCollection $items, PayBuddy $paymentProvider, string $paymentToken, int $userId): Order
    {
        $orderTotalInCents = $items->totalInCents();

        return $this->databaseManager->transaction(function () use ($items, $orderTotalInCents, $userId, $paymentProvider, $paymentToken) {
            $order = Order::query()->create([
                'status' => 'completed',
                'total_in_cents' => $orderTotalInCents,
                'user_id' => $userId,
            ]);

            $order->lines()->createMany($items->items()->map(function (CartItem $cartItem) {
                $this->productStockManager->decrement($cartItem->product->id, $cartItem->quantity);
                return [
                    'product_id' => $cartItem->product->id,
                    'product_price_in_cents' => $cartItem->product->priceInCents,
                    'quantity' => $cartItem->quantity,
                ];
            }));

            $this->createActionsForOrder->handle(
                $order->id,
                $userId,
                $orderTotalInCents,
                $paymentProvider,
                $paymentToken
            );
            return $order;
        });
    }
}
