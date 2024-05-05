<?php

namespace Modules\Order\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Modules\Order\OrderLine;

readonly class OrderLineDto
{
    /**
     * @param int $productId
     * @param int $productPriceInCents
     * @param int $quantity
     */
    public function __construct(
        public int $productId,
        public int $productPriceInCents,
        public int $quantity,
    )
    {}

    /**
     * @param OrderLine $line
     * @return OrderLineDto
     */
    public static function fromEloquentModel(OrderLine $line): OrderLineDto
    {
        return new self(
            productId: $line->product_id,
            productPriceInCents: $line->product_price_in_cents,
            quantity: $line->quantity
        );
    }

    /**
     * @param Collection $orderLines
     * @return array
     */
    public static function fromEloquentCollection(Collection $orderLines): array
    {
        return $orderLines->map(fn(OrderLine $line) => self::fromEloquentModel($line))->toArray();
    }

}
