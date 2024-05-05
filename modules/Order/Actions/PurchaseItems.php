<?php

namespace Modules\Order\Actions;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\DatabaseManager;
use Modules\Order\DTOs\OrderDto;
use Modules\Order\Events\OrderFullfilled;
use Modules\Order\Mail\OrderReceived;
use Modules\Order\Models\Order;
use Modules\Payment\Actions\CreateActionsForOrder;
use Modules\Payment\PayBuddy;
use Modules\Product\CartItemCollection;
use Modules\Product\DTOs\PendingPayment;
use Modules\Product\Warehouse\ProductStockManager;
use Modules\User\UserDto;

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
    public function handle(CartItemCollection $items, PendingPayment $pendingPayment , UserDto $user): OrderDto
    {
        /** @var OrderDto $order */
        $order = $this->databaseManager->transaction(function () use ($items, $user, $pendingPayment) {

            $order = Order::startForUser($user->id);
            $order->addLinesFromCartItems($items);
            $order->fulFill();

            $this->createActionsForOrder->handle(
                $order->id,
                $user->id,
                $items->totalInCents(),
                $pendingPayment->provider,
                $pendingPayment->paymentToken
            );

            return OrderDto::fromEloquentModel($order);
        });

        $this->events->dispatch(new OrderFullfilled($order, $user) );

        return $order;
    }
}
