<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'sku',
        'price',
        'sale_price',
        'cost_price',
        'stock_quantity',
        'manage_stock',
        'stock_status',
        'weight',
        'dimensions',
        'category_id',
        'brand_id',
        'status',
        'featured',
        'gallery',
        'meta_title',
        'meta_description',
        'material',
        'color',
        'style',
        'room_type'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'stock_quantity' => 'integer',
        'manage_stock' => 'boolean',
        'status' => 'boolean',
        'featured' => 'boolean',
        'gallery' => 'array',
        'dimensions' => 'array'
    ];

    // Category relationship
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Brand relationship
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // Reviews relationship
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Cart items relationship
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    // Order items relationship
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Wishlist relationship
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    // Scope for active products
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // Scope for featured products
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    // Scope for in stock products
    public function scopeInStock($query)
    {
        return $query->where('stock_status', 'in_stock')
                    ->where('stock_quantity', '>', 0);
    }

    // Get effective price
    public function getEffectivePriceAttribute()
    {
        return $this->sale_price ?: $this->price;
    }

    // Check if product is on sale
    public function getIsOnSaleAttribute()
    {
        return $this->sale_price && $this->sale_price < $this->price;
    }

    // Get discount percentage
    public function getDiscountPercentageAttribute()
    {
        if (!$this->is_on_sale) {
            return 0;
        }
        
        return round((($this->price - $this->sale_price) / $this->price) * 100);
    }

    // Get average rating
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    // Get total reviews count
    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->count();
    }

    // Get main image
    public function getMainImageAttribute()
    {
        return $this->gallery[0] ?? '/images/placeholder-product.jpg';
    }

    // Check stock availability
    public function isInStock($quantity = 1)
    {
        if (!$this->manage_stock) {
            return $this->stock_status === 'in_stock';
        }
        
        return $this->stock_quantity >= $quantity;
    }
}
