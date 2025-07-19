<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'phone',
        'date_of_birth',
        'gender',
        'avatar',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'status' => 'boolean'
    ];

    // Addresses relationship
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    // Default address relationship
    public function defaultAddress()
    {
        return $this->hasOne(Address::class)->where('is_default', true);
    }

    // Orders relationship
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Cart relationship
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    // Cart items relationship
    public function cartItems()
    {
        return $this->hasManyThrough(CartItem::class, Cart::class);
    }

    // Wishlist relationship
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    // Reviews relationship
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Get or create cart
    public function getOrCreateCart()
    {
        return $this->cart ?: $this->cart()->create();
    }

    // Check if admin
    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    // Check if customer
    public function isCustomer()
    {
        return $this->hasRole('customer');
    }
}
