<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemSuccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'price',
        'discount',
        'quantity',
        'product'
    ];

    protected $casts = [
        'price' => 'float',
        'discount' => 'float'
    ];
}
