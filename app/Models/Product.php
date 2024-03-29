<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'developer',
        'publisher',
        'platform',
        'launcher',
        'users_id'
    ];

    //relation carts M-M
    public function carts(){
        // id otra tabla, id propia, id intermedia
        return $this->belongsToMany(Cart::class, 'carts_has_products', 'products_id', 'carts_id')->withPivot('quantity');
    }
    //? relation categories M-M
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'categories_has_products', 'products_id', 'categories_id')
            ->withTimestamps();
    }
    //? wishlist relation M-M
    public function wishlists()
    {
        return $this->belongsToMany(Wishlist::class, 'wishlists_has_products', 'products_id', 'wishlists_id')
            ->withTimestamps();
    }
    //? orders relation M-M
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'orders_has_products', 'products_id', 'orders_id')
            ->withTimestamps();
    }
    //? user relation 1-M
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    //! discounts relation 1-M deleted 
    // public function discounts()
    // {
    //     return $this->hasMany(Discount::class, 'products_id');
    // }
    //? images relation N-M
    public function images()
    {
        return $this->belongsToMany(Image::class, 'products_has_images', 'products_id', 'images_id')
            ->withTimestamps();
    }
    
    // review relation 1-M
    //  public function reviews() {
    //      return $this->hasMany(Review::class,'reviews_id');
    //  }
}
