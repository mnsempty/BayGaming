<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    // users relation 1-1
    public function user() {
        return $this->belongsTo(User::class,"wishlists_id");
    }
    //product relation 1-m
    public function product() {
        return $this->belongsTo(product::class);
    }
}
