<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;
    //relation order prob to change
    function order() {
        return $this->belongsTo(order::class);
    }
}
