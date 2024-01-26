<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    //terminar enlace products (laravel002)
    public function categories() {
        return $this->belongsToMany(Category::class, 'category_has_product', 'product_id', 'category_id')
        ->withTimestamps();
    }
}
