<?php

use Modules\Order\Infrastructure\Providers\OrderServiceProvider;
use Modules\Payment\Infrastructure\Providers\PaymentServiceProvider;
use Modules\Product\Providers\ProductServiceProvider;
use Modules\Shipment\Providers\ShipmentServiceProvider;

return [
    /**
     * Application Service Providers...
    */
    App\Providers\AppServiceProvider::class,
    OrderServiceProvider::class,
    ProductServiceProvider::class,
    ShipmentServiceProvider::class,
    PaymentServiceProvider::class
];
