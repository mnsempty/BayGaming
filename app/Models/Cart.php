<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // relation cart_has_product N-M
    public function product()
    {
        return $this->belongsToMany(Category::class, 'cart_has_product', 'cart_id', 'product_id')
            ->withTimestamps();
    }
}
