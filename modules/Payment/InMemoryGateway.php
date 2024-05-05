<?php

namespace Modules\Payment;

class InMemoryGateway implements PaymentGateway
{
    public function charge(PaymentDetails $details): SuccessfulPayment
    {
        return new SuccessfulPayment(uniqid(), $details->amountInCents, $this->id());
    }

    public function id(): PaymentProvider
    {
        return PaymentProvider::InMemory;
    }
}
