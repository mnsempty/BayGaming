<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    public function user() {
    return $this->hasMany(User::class,'address_id');
    // return $this->belongsTo(Address::class);

    }
}
