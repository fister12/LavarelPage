<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id'
    ];

    // User relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Cart items relationship
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    // Get total quantity
    public function getTotalQuantityAttribute()
    {
        return $this->items->sum('quantity');
    }

    // Get total amount
    public function getTotalAmountAttribute()
    {
        return $this->items->sum(function ($item) {
            return $item->quantity * $item->product->effective_price;
        });
    }

    // Add item to cart
    public function addItem($productId, $quantity = 1)
    {
        $existingItem = $this->items()->where('product_id', $productId)->first();
        
        if ($existingItem) {
            $existingItem->increment('quantity', $quantity);
            return $existingItem;
        }
        
        return $this->items()->create([
            'product_id' => $productId,
            'quantity' => $quantity
        ]);
    }

    // Remove item from cart
    public function removeItem($productId)
    {
        return $this->items()->where('product_id', $productId)->delete();
    }

    // Update item quantity
    public function updateItem($productId, $quantity)
    {
        if ($quantity <= 0) {
            return $this->removeItem($productId);
        }
        
        return $this->items()->where('product_id', $productId)->update(['quantity' => $quantity]);
    }

    // Clear cart
    public function clear()
    {
        return $this->items()->delete();
    }
}
