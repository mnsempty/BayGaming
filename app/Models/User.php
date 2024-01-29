<?php

namespace App\Models;

// uncomment fortify
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    //address relation 1-M
    function address() {
        return $this->belongsTo(Address::class);
    }
    // orders relation 1-M
    function order() {
        return $this->belongsTo(Order::class);
    }
    // reviews relation 1-M
    function review() {
        return $this->belongsTo(review::class);
    }
    // Wishlist relation 1-1
    function wishlist() {
        return $this->hasOne(Wishlist::class);
    }
}
