<?php

namespace Modules\Product\DTOs;

use Modules\Payment\PayBuddy;

readonly class PendingPayment
{

    /**
     * @param PayBuddy $provider
     * @param string $paymentToken
     */
    public function __construct(
        public PayBuddy $provider,
        public string $paymentToken
    )
    {
    }
}
