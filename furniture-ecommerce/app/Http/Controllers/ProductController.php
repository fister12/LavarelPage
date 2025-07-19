<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'reviews'])
            ->active()
            ->inStock();

        // Filter by category
        if ($request->has('category') && $request->category) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $categoryIds = [$category->id];
                // Include child categories
                $categoryIds = array_merge($categoryIds, $category->children->pluck('id')->toArray());
                $query->whereIn('category_id', $categoryIds);
            }
        }

        // Filter by brand
        if ($request->has('brand') && $request->brand) {
            $brand = Brand::where('slug', $request->brand)->first();
            if ($brand) {
                $query->where('brand_id', $brand->id);
            }
        }

        // Filter by price range
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by room type
        if ($request->has('room_type') && $request->room_type) {
            $query->where('room_type', $request->room_type);
        }

        // Filter by material
        if ($request->has('material') && $request->material) {
            $query->where('material', $request->material);
        }

        // Filter by color
        if ($request->has('color') && $request->color) {
            $query->where('color', $request->color);
        }

        // Sort options
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');

        switch ($sortBy) {
            case 'price_low_high':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high_low':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->latest();
                break;
            case 'rating':
                $query->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc');
                break;
            default:
                $query->orderBy($sortBy, $sortOrder);
        }

        $products = $query->paginate(12)->withQueryString();

        // Get filter options
        $categories = Category::active()->main()->with('children')->orderBy('sort_order')->get();
        $brands = Brand::active()->orderBy('name')->get();
        $roomTypes = Product::distinct()->pluck('room_type')->filter()->sort();
        $materials = Product::distinct()->pluck('material')->filter()->sort();
        $colors = Product::distinct()->pluck('color')->filter()->sort();

        return view('products.index', compact(
            'products',
            'categories',
            'brands',
            'roomTypes',
            'materials',
            'colors'
        ));
    }

    public function show($slug)
    {
        $product = Product::with(['category', 'brand', 'reviews.user'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        // Related products
        $relatedProducts = Product::with(['category', 'brand'])
            ->active()
            ->inStock()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(8)
            ->get();

        // Check if user has this product in wishlist
        $inWishlist = false;
        if (auth()->check()) {
            $inWishlist = auth()->user()->wishlists()
                ->where('product_id', $product->id)
                ->exists();
        }

        return view('products.show', compact('product', 'relatedProducts', 'inWishlist'));
    }

    public function quickView($id)
    {
        $product = Product::with(['category', 'brand'])
            ->findOrFail($id);

        return view('products.quick-view', compact('product'));
    }
}
