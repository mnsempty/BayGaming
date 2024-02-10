<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;


    protected $fillable = [
        'users_id',
    ];

    //? users relation 1-1
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id'); 
    }

    //?relation categories M-M
    public function products()
    {
        return $this->belongsToMany(Product::class, 'wishlists_has_products', 'wishlists_id', 'products_id')
            ->withTimestamps();
    }
}
