<?php

namespace Modules\Payment\Actions;

use Modules\Payment\Exceptions\PaymentFailedException;
use Modules\Payment\Payment;
use Modules\Payment\PaymentDetails;
use Modules\Payment\PaymentGateway;
use RuntimeException;

class CreatePaymentForOrder implements CreatePaymentForOrderInterface
{
    /**
     * @param int $orderId
     * @param int $userId
     * @param int $totalInCents
     * @param PaymentGateway $paymentGateway
     * @param string $paymentToken
     * @return Payment
     */
    public function handle(
        int         $orderId,
        int         $userId,
        int         $totalInCents,
        PaymentGateway $paymentGateway,
        string  $paymentToken
    ): Payment
    {
        try {
            $charge = $paymentGateway->charge(new PaymentDetails($paymentToken, $totalInCents, 'Order #' . $orderId));
        }catch (RuntimeException){
            throw PaymentFailedException::dueToInvalidPaymentToken();
        }

        return Payment::query()->create([
            'total_in_cents' => $charge->amountInCents,
            'status' => 'paid',
            'payment_gateway' => $charge->paymentProvider,
            'payment_id' => $charge->id,
            'user_id' => $userId,
            'order_id' => $orderId
        ]);
    }
}
