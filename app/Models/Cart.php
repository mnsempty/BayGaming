<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'users_id',
    ];
    public function products(){
        // id otra tabla, id propia, id intermedia
        return $this->belongsToMany(Product::class, 'carts_has_products', 'carts_id', 'products_id')->withTimestamps();
    }
    //? done
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
