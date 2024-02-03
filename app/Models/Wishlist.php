<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    //? users relation 1-1
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //?relation categories M-M
    public function products()
    {
        return $this->belongsToMany(Product::class, 'wishlists_has_products', 'wishlists_id', 'products_id')
            ->withTimestamps();
    }
}
