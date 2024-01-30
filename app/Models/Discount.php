<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    //relation order prob to change
    public function orders() {
        return $this->hasMany(order::class,'orders_id');
    }

}
