<?php

namespace App\Models;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'discount',
        'author',
        'publisher',
        'genre',
        'language',
        'country',
        'published',
        'description',
        'image',
        'user',
        'category'
    ];

    protected $casts = [
        'image' => 'array',
        'isShow' => 'boolean',
        'price' => 'float',
        'discount' => 'float',
        'averageRating' => 'float'
    ];



    public function user(){
        return $this->belongsTo(User::class, 'user');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category');
    }
}
