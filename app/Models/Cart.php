<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    public function Products(){
        // id otra tabla, id propia, id intermedia
        return $this->belongsToMany(Product::class, 'cart_has_product', 'cart_id', 'product_id');
    }
}
