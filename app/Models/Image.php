<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    // relacion products N-M
    public function products()
    {
        return $this->belongsToMany(Product::class, 'products_has_images', 'images_id', 'products_id')
            ->withTimestamps();
    }
    
}
