<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    // relacion products 1-M
    function products() {
        return $this->belongsTo(Product::class);
    }
    
}
