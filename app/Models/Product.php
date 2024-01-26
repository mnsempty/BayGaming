<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    // terminar enlace products (laravel002)
    public function Catogory(){
        // id otra tabla, id propia, id intermedia
        return $this->belongsToMany(Category::class,'category_id','product_id');
    }
}
