<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['rating', 'comment', 'user', 'product'];

    protected $casts = [
        'rating' => 'float'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product');
    }

}
