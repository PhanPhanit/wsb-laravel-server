<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Slide extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'subtitle', 'product', 'user'];

    protected $casts = [
        'isShow' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user');
    }

}
