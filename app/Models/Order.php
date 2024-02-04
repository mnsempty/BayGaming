<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    // not now
    // public function invoice() {
    //     return $this->hasOne(Invoice::class);
    // }

    protected $fillable = ['users_id', 'state', 'total'];

    //? done
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
    //? done
    public function products()
    {
        return $this->belongsToMany(Product::class, 'orders_has_products', 'orders_id', 'products_id')
        ->withPivot('quantity') //*Para que tambien lleve la cantidad de productos y se pueda mostrar desde la vista
        ->withTimestamps();
    }
}
