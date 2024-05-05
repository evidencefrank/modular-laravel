<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace Modules\Order\Models{
/**
 *
 *
 * @property int $id
 * @property int $user_id
 * @property int $total_in_cents
 * @property string $status
 * @property string $payment_gateway
 * @property string $payment_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Modules\Payment\Payment|null $lastPayment
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Order\OrderLine> $lines
 * @property-read int|null $lines_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Modules\Payment\Payment> $payments
 * @property-read int|null $payments_count
 * @property-read \App\Models\User|null $user
 * @method static \Modules\Order\Infrastructure\Database\Factories\OrderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Order\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Order\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Order\Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Order\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Order\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Order\Order wherePaymentGateway($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Order\Order wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Order\Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Order\Order whereTotalInCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Order\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Order\Order whereUserId($value)
 */
	class Order extends \Eloquent {}
}

namespace Modules\Order\Models{
/**
 *
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int $product_price_in_cents
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Modules\Order\Infrastructure\Database\Factories\OrderLineFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Order\OrderLine newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Order\OrderLine newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Order\OrderLine query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Order\OrderLine whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Order\OrderLine whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Order\OrderLine whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Order\OrderLine whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Order\OrderLine whereProductPriceInCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Order\OrderLine whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Modules\Order\OrderLine whereUpdatedAt($value)
 */
	class OrderLine extends \Eloquent {}
}

namespace Modules\Payment{
/**
 *
 *
 * @property-read \Modules\Order\Order|null $order
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 */
	class Payment extends \Eloquent {}
}

namespace Modules\Product\Models{
/**
 *
 *
 * @property int $id
 * @property int $quantity
 * @property int $user_id
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Modules\Product\Database\Factories\CartItemFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CartItem whereUserId($value)
 */
	class CartItem extends \Eloquent {}
}

namespace Modules\Product\Models{
/**
 *
 *
 * @property int $id
 * @property string $name
 * @property string $price
 * @property int $stock
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Modules\Product\Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 */
	class Product extends \Eloquent {}
}

namespace Modules\Shipment\Models{
/**
 *
 *
 * @property int $id
 * @property int $user_id
 * @property int $total_in_cents
 * @property string $payment_gateway
 * @property string $payment_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Modules\Shipment\Database\Factories\ShipmentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment wherePaymentGateway($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereTotalInCents($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Shipment whereUserId($value)
 */
	class Shipment extends \Eloquent {}
}

