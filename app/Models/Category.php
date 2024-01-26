<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
        // terminar enlace products (laravel002)
        public function Product(){
            // id otra tabla, id propia, id intermedia
            return $this->belongsToMany(Product::class,'product_id','category_id');
        }
}
