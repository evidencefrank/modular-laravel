<?php

namespace Modules\Order\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Modules\Order\Http\Requests\CheckoutRequest;
use Modules\Order\Models\Order;
use Modules\Payment\PayBuddy;
use Modules\Product\CartItem;
use Modules\Product\CartItemCollection;
use Modules\Product\Warehouse\ProductStockManager;
use RuntimeException;

class CheckoutController
{
    public function __construct(
        protected ProductStockManager $productStockManager
    )
    {}

    /**
     * @throws ValidationException
     */
    public function __invoke(CheckoutRequest $request): JsonResponse
    {
        $cartItems = CartItemCollection::fromCheckoutRequest($request->input('products'));
        $orderTotalInCents = $cartItems->totalInCents();

        $payBuddy = PayBuddy::make();
        try {
            $charge = $payBuddy->charge($request->input('payment_token'), $orderTotalInCents, 'Modules Order');
        }catch (RuntimeException){
            throw ValidationException::withMessages([
                'payment_token' => 'We could not complete your payment.'
            ]);
        }

        $order = Order::query()->create([
            'status' => 'completed',
            'total_in_cents' => $orderTotalInCents,
            'user_id' => $request->user()->id,
        ]);

        $order->lines()->createMany($cartItems->items()->map(function (CartItem $cartItem) {
            $this->productStockManager->decrement($cartItem->product->id, $cartItem->quantity);
            return [
                'product_id' => $cartItem->product->id,
                'product_price_in_cents' => $cartItem->product->priceInCents,
                'quantity' => $cartItem->quantity,
            ];
        }));

        $payment = $order->payments()->create([
            'total_in_cents' => $orderTotalInCents,
            'status' => 'paid',
            'payment_gateway' => 'PayBuddy',
            'payment_id' => $charge['id'],
            'user_id' => $request->user()->id,
        ]);

        return response()->json([], 201);
    }
}
