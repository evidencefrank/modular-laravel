<?php

namespace Modules\Order\Actions;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\DatabaseManager;
use Modules\Order\Events\OrderFullfilled;
use Modules\Order\Mail\OrderReceived;
use Modules\Order\Models\Order;
use Modules\Payment\Actions\CreateActionsForOrder;
use Modules\Payment\PayBuddy;
use Modules\Product\CartItemCollection;
use Modules\Product\Warehouse\ProductStockManager;

class PurchaseItems
{
    public function __construct(
        protected ProductStockManager $productStockManager,
        protected CreateActionsForOrder $createActionsForOrder,
        protected DatabaseManager $databaseManager,
        protected Dispatcher $events
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
    public function handle(CartItemCollection $items, PayBuddy $paymentProvider, string $paymentToken, int $userId, string $userEmail): Order
    {
        /** @var Order $order */
        $order = $this->databaseManager->transaction(function () use ($items, $userId, $paymentProvider, $paymentToken) {

            $order = Order::startForUser($userId);
            $order->addLinesFromCartItems($items);
            $order->fulFill();

            $this->createActionsForOrder->handle(
                $order->id,
                $userId,
                $items->totalInCents(),
                $paymentProvider,
                $paymentToken
            );

            return $order;
        });

        $this->events->dispatch(
            new OrderFullfilled($order->id, $order->total_in_cents, $order->localizedTotal(), $items, $userId, $userEmail)
        );

        return $order;
    }
}
