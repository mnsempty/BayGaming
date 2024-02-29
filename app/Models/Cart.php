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
    public function products()
    {
        return $this->belongsToMany(Product::class, 'carts_has_products', 'carts_id', 'products_id')->withPivot('quantity');
    }
    //? done
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function getTotalQuantityAttribute()
    {
        return $this->products->sum('pivot.quantity');
    }

}
