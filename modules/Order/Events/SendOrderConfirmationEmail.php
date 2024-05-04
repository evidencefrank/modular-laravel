<?php

namespace Modules\Order\Events;

use Illuminate\Support\Facades\Mail;
use Modules\Order\Mail\OrderReceived;

class SendOrderConfirmationEmail
{
    public function handle(OrderFullfilled $event): void
    {
        Mail::to($event->userEmail)
            ->send(new OrderReceived($event->localizedTotal));
    }
}
