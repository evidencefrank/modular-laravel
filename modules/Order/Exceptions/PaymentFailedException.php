<?php

namespace Modules\Order\Exceptions;

class PaymentFailedException extends \RuntimeException
{
    public static function dueToInvalidPaymentToken(): self
    {
        return new self('The given payment token is invalid.');
    }
}
