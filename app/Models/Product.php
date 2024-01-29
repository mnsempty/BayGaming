<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    //relation categories M-M
    public function categories() {
        return $this->belongsToMany(Category::class, 'category_has_product', 'product_id', 'category_id')
        ->withTimestamps();
    }
    // wishlist relation 1-M
     public function wishlist() {
        return $this->hasMany(wishlist::class,'product_id');
        }
    // images relation 1-M
    function images() {
        return $this->hasMany(Image::class,'products_id');
        }
}
