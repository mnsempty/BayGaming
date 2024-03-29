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
    //? address relation 1-M
    public function addresses()
    {
        return $this->hasMany(Address::class, 'users_id');
    }

    //? orders relation 1-M
    public function orders()
    {
        return $this->hasMany(Order::class, 'users_id');
    }

    //? 1-M
    public function cart()
    {
        return $this->hasOne(Cart::class, 'users_id');
    }
    //? 1-1
    public function wishlist()
    {
        return $this->hasOne(Wishlist::class, 'users_id'); 
    }
    //? address relation 1-M
    public function products()
    {
        return $this->hasMany(Product::class, 'users_id');
    }

    
    // reviews relation 1-M 
    // public function reviews() {
    //     return $this->hasMany(Review::class,'user_id');
    // }

    // Wishlist relation 1-1
    // public function wishlist() {
    //     return $this->hasOne(Wishlist::class);
    // }

}
