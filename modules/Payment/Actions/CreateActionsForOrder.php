<?php

namespace Modules\Payment\Actions;

use Modules\Order\Exceptions\PaymentFailedException;
use Modules\Payment\PayBuddy;
use Modules\Payment\Payment;
use RuntimeException;

class CreateActionsForOrder
{
    /**
     * @param int $orderId
     * @param int $userId
     * @param int $totalInCents
     * @param PayBuddy $payBuddy
     * @param string $paymentToken
     * @return Payment
     * @throws PaymentFailedException
     */
    public function handle(
        int $orderId,
        int $userId,
        int $totalInCents,
        PayBuddy $payBuddy,
        string $paymentToken
    ): Payment
    {
        try {
            $charge = $payBuddy->charge($paymentToken, $totalInCents, 'Modules Order');
        }catch (RuntimeException){
            throw PaymentFailedException::dueToInvalidPaymentToken();
        }

        return Payment::query()->create([
            'total_in_cents' => $charge['amount_in_cents'],
            'status' => 'paid',
            'payment_gateway' => 'PayBuddy',
            'payment_id' => $charge['id'],
            'user_id' => $userId,
            'order_id' => $orderId
        ]);
    }
}
