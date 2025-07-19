<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'status',
        'sort_order'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    // Products relationship
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Scope for active brands
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
