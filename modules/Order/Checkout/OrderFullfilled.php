<?php

namespace Modules\Order\Checkout;

use Modules\Order\Contracts\OrderDto;
use Modules\User\UserDto;

readonly class OrderFullfilled
{
    public function __construct(
        public OrderDto $order,
        public UserDto $user,
    )
    {}
}
