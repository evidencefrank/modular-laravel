<?php

namespace Modules\Order\Checkout;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Modules\Payment\Exceptions\PaymentFailedException;
use Modules\Payment\PaymentGateway;
use Modules\Product\Collections\CartItemCollection;
use Modules\Product\DTOs\PendingPayment;
use Modules\User\UserDto;

class CheckoutController
{
    public function __construct(
        protected PurchaseItems $purchaseItems,
        protected PaymentGateway $paymentGateway
    )
    {}

    /**
     * @throws ValidationException|\Throwable
     */
    public function __invoke(CheckoutRequest $request): JsonResponse
    {
        $cartItems = CartItemCollection::fromCheckoutRequest($request->input('products'));
        $pendingPayment = new PendingPayment($this->paymentGateway, $request->input('payment_token'));
        $userDto = UserDto::fromEloquentModel($request->user());

        try {
            $order = $this->purchaseItems->handle($cartItems, $pendingPayment, $userDto);
        } catch (PaymentFailedException) {
            throw ValidationException::withMessages([
                'payment_token' => 'We could not complete your payment.'
            ]);
        }

        return response()->json([
            'order_url' => $order->url
        ], 201);
    }
}
