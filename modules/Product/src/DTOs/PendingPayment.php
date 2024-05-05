<?php

namespace Modules\Product\DTOs;

use Modules\Payment\PaymentGateway;

readonly class PendingPayment
{

    /**
     * @param PaymentGateway $paymentGateway
     * @param string $paymentToken
     */
    public function __construct(
        public PaymentGateway $paymentGateway,
        public string $paymentToken
    )
    {}
}
