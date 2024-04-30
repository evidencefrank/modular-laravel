<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'user_id'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'product_id' => 'integer',
        'user_id' => 'integer'
    ];
}
