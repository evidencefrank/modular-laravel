<?php

namespace Modules\Product;

use Illuminate\Support\Collection;
use Modules\Product\Models\Product;

readonly class CartItemCollection
{
    /** @param \Illuminate\Support\Collection<CartItem> $items*/
    public function __construct( protected Collection $items){}

    /**
     * @param array $data
     * @return CartItemCollection
     */
    public static function fromCheckoutRequest(array $data): CartItemCollection
    {
        $cartItems =  collect($data)->map(function (array $productDetails) {
            return new CartItem(
                ProductDto::fromEloquentModel(Product::query()->find($productDetails['id'])),
                $productDetails['quantity']);
        });
        return new self($cartItems);
    }

    /**
     * @return int
     */
    public function totalInCents(): int
    {
        return $this->items->sum(fn(CartItem $cartItem) =>
            $cartItem->product->priceInCents * $cartItem->quantity
        );
    }

    /**
     * @return \Illuminate\Support\Collection<CartItem>
     */
    public function items(): Collection
    {
        return $this->items;
    }
}
