<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery',
        'subtotal',
        'total',
        'user',
        'paymentIntent',
        'phoneNumber',
        'city',
        'address',
        'orderDate'
    ];

    protected $casts = [
        'delivery' => 'float',
        'subtotal' => 'float',
        'total' => 'float'
    ];

    public function orderItem()
    {
        return $this->hasMany(OrderItemSuccess::class, 'order', 'id')->select('id', 'name', 'image', 'price', 'discount', 'quantity', 'product', 'order');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user')->select('id', 'name', 'email', 'googleId', 'facebookId', 'role', 'isActive');
    }
}
