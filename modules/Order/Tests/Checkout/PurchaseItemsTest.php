<?php

namespace Modules\Order\Tests\Checkout;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Modules\Order\Checkout\OrderFullfilled;
use Modules\Order\Checkout\PurchaseItems;
use Modules\Order\Order;
use Modules\Payment\Actions\CreatePaymentForOrderInMemory;
use Modules\Payment\Actions\CreatePaymentForOrderInterface;
use Modules\Payment\Exceptions\PaymentFailedException;
use Modules\Payment\InMemoryGateway;
use Modules\Payment\PayBuddySdk;
use Modules\Payment\Payment;
use Modules\Product\Collections\CartItemCollection;
use Modules\Product\Database\factories\ProductFactory;
use Modules\Product\DTOs\PendingPayment;
use Modules\Product\DTOs\ProductDto;
use Modules\User\UserDto;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PurchaseItemsTest extends TestCase
{
    use DatabaseMigrations;

    #[Test]
    public function it_creates_an_order(): void
    {
        Mail::fake();
        Event::fake();

        $user = UserFactory::new()->create();
        $product = ProductFactory::new()->create([
            'stock' => 10,
            'price_in_cents' => 100_00
        ]);

        $createPaymentForOrder = new CreatePaymentForOrderInMemory();
        $this->app->instance(CreatePaymentForOrderInterface::class, $createPaymentForOrder);

        $cartItemCollection = CartItemCollection::fromProduct(ProductDto::fromEloquentModel($product), 2);
        $pendingPayment = new PendingPayment(new InMemoryGateway(), PayBuddySdk::validToken());
        $userDto = UserDto::fromEloquentModel($user);

        $purchaseItems = app(PurchaseItems::class);
        $order = $purchaseItems->handle($cartItemCollection, $pendingPayment, $userDto);

        $orderLine = $order->lines[0];

        $this->assertEquals($product->price_in_cents * 2, $order->totalInCents);
        $this->assertCount(1, $order->lines);
        $this->assertEquals($product->id, $orderLine->productId);
        $this->assertEquals($product->price_in_cents, $orderLine->productPriceInCents);
        $this->assertEquals(2, $orderLine->quantity);

        $payment = $createPaymentForOrder->payments[0];
        $this->assertCount(1, $createPaymentForOrder->payments);
        $this->assertEquals($order->id, $payment->order_id);
        $this->assertEquals($userDto->id, $payment->user_id);


        Event::assertDispatched(OrderFullfilled::class, function (OrderFullfilled $event) use ($userDto, $order) {
            return $event->order === $order && $event->user === $userDto;
        });
    }

    #[Test]
    public function it_does_not_create_an_order_if_something_fails(): void
    {
        Mail::fake();
        Event::fake();

        $this->expectException(PaymentFailedException::class);

        $createPaymentForOrder = new CreatePaymentForOrderInMemory();
        $createPaymentForOrder->shouldFail();
        $this->app->instance(CreatePaymentForOrderInterface::class, $createPaymentForOrder);

        $user = UserFactory::new()->create();
        $product = ProductFactory::new()->create();

        $cartItemCollection = CartItemCollection::fromProduct(ProductDto::fromEloquentModel($product), 2);
        $pendingPayment = new PendingPayment(new InMemoryGateway(), PayBuddySdk::validToken());
        $userDto = UserDto::fromEloquentModel($user);

        $purchaseItems = app(PurchaseItems::class);

        try {
            $purchaseItems->handle($cartItemCollection, $pendingPayment, $userDto);
        } finally {
            $this->assertEquals(0, Order::query()->count());
            $this->assertEquals(0, Payment::query()->count());
            $this->assertCount(0, $createPaymentForOrder->payments);
            Event::assertNotDispatched(OrderFullfilled::class);
        }
    }


}
