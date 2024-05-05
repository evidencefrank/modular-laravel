<?php

namespace Modules\Payment;

interface PaymentGateway
{
    /**
     * @param PaymentDetails $details
     * @return SuccessfulPayment
     */
    public function charge(PaymentDetails $details): SuccessfulPayment;

    public function id(): PaymentProvider;
}
