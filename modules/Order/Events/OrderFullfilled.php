<?php

namespace Modules\Order\Events;

use Modules\Order\DTOs\OrderDto;
use Modules\User\UserDto;

readonly class OrderFullfilled
{
    public function __construct(
        public OrderDto $order,
        public UserDto $user,
    )
    {}
}
