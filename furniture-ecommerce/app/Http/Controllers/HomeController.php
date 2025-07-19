<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Featured products
        $featuredProducts = Product::with(['category', 'brand'])
            ->active()
            ->featured()
            ->inStock()
            ->take(8)
            ->get();

        // New arrivals
        $newArrivals = Product::with(['category', 'brand'])
            ->active()
            ->inStock()
            ->latest()
            ->take(8)
            ->get();

        // Best sellers (based on order count)
        $bestSellers = Product::with(['category', 'brand'])
            ->active()
            ->inStock()
            ->withCount('orderItems')
            ->orderBy('order_items_count', 'desc')
            ->take(8)
            ->get();

        // Sale products
        $saleProducts = Product::with(['category', 'brand'])
            ->active()
            ->inStock()
            ->whereNotNull('sale_price')
            ->take(8)
            ->get();

        // Main categories
        $mainCategories = Category::active()
            ->main()
            ->with('children')
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        // Popular brands
        $popularBrands = Brand::active()
            ->withCount('products')
            ->orderBy('products_count', 'desc')
            ->take(8)
            ->get();

        return view('home', compact(
            'featuredProducts',
            'newArrivals',
            'bestSellers',
            'saleProducts',
            'mainCategories',
            'popularBrands'
        ));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (empty($query)) {
            return redirect()->route('home');
        }

        $products = Product::with(['category', 'brand'])
            ->active()
            ->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('short_description', 'LIKE', "%{$query}%")
                  ->orWhere('sku', 'LIKE', "%{$query}%");
            })
            ->paginate(12);

        return view('search', compact('products', 'query'));
    }
}
