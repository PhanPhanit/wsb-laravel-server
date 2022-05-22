<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'image', 'isShow', 'user'];

    protected $casts = [
        'isShow' => 'boolean'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user');
    }
}
