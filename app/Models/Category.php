<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // use HasFactory;
    // terminar enlace products (laravel002)
    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_has_product', 'category_id', 'product_id')
            ->withTimestamps();
    }

}
