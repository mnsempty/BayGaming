<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    // terminar enlace products (laravel002)
    public function Carts(){
        // id otra tabla, id propia, id intermedia
        return $this->belongsToMany(Cart::class, 'cart_has_product', 'product_id', 'cart_id');
    }
}
