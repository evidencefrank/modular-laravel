<?php

namespace Modules\Order\Actions;

use Modules\Order\Exceptions\PaymentFailedException;
use Modules\Order\Models\Order;
use Modules\Payment\PayBuddy;
use Modules\Product\CartItem;
use Modules\Product\CartItemCollection;
use Modules\Product\Warehouse\ProductStockManager;
use RuntimeException;

class PurchaseItems
{
    public function __construct(
        protected ProductStockManager $productStockManager,
    )
    {}

    /**
     * @param CartItemCollection $items
     * @param PayBuddy $paymentProvider
     * @param string $paymentToken
     * @param int $userId
     * @return Order
     */
    public function handle(CartItemCollection $items, PayBuddy $paymentProvider, string $paymentToken, int $userId): Order
    {
        $orderTotalInCents = $items->totalInCents();
        try {
            $charge = $paymentProvider->charge($paymentToken, $orderTotalInCents, 'Modules Order');
        }catch (RuntimeException){
            throw PaymentFailedException::dueToInvalidPaymentToken();
        }

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

        $order->payments()->create([
            'total_in_cents' => $orderTotalInCents,
            'status' => 'paid',
            'payment_gateway' => 'PayBuddy',
            'payment_id' => $charge['id'],
            'user_id' => $userId,
        ]);

        return $order->refresh();
    }
}
