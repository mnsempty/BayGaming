<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    //relation carts M-M
    public function Carts(){
        // id otra tabla, id propia, id intermedia
        return $this->belongsToMany(Cart::class, 'cart_has_product', 'product_id', 'cart_id');
    }
        //relation categories M-M
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'categories_has_products', 'products_id', 'categories_id')
            ->withTimestamps();
    }
    // wishlist relation 1-M
    public function wishlists()
    {
        return $this->hasMany(wishlist::class, 'products_id');
    }

    // images relation N-M
    public function images()
    {
        return $this->belongsToMany(Category::class, 'products_has_images', 'products_id', 'images_id')
            ->withTimestamps();
    }
    // review relation 1-M
    public function reviews() {
        return $this->hasMany(Review::class,'reviews_id');
    }
}
