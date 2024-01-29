<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    // users relation 1-1
    function users() {
        return $this->belongsTo(User::class,"wishlist_id");
    }
    //product relation
    function product() {
        return $this->belongsTo(product::class);
    }
}
