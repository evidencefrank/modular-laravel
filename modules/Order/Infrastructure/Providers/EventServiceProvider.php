<?php

namespace Modules\Order\Infrastructure\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as BaseEventServiceProvider;
use Modules\Order\Checkout\OrderFullfilled;
use Modules\Order\Checkout\SendOrderConfirmationEmail;

class EventServiceProvider extends BaseEventServiceProvider
{
    protected $listen = [
        OrderFullfilled::class => [
            SendOrderConfirmationEmail::class
        ],
    ];

}
