<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    //relation carts M-M
    public function carts(){
        // id otra tabla, id propia, id intermedia
        return $this->belongsToMany(Cart::class, 'carts_has_products', 'products_id', 'carts_id');
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

    // relation cart_has_product N-M
    public function cart()
    {
        return $this->belongsToMany(Category::class, 'cart_has_product', 'cart_id', 'product_id')
            ->withTimestamps();
    }
}
