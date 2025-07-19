<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $wishlists = auth()->user()->wishlists()
            ->with('product.category', 'product.brand')
            ->latest()
            ->paginate(12);

        return view('wishlist.index', compact('wishlists'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if already in wishlist
        $exists = auth()->user()->wishlists()
            ->where('product_id', $request->product_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Product is already in your wishlist'
            ]);
        }

        auth()->user()->wishlists()->create([
            'product_id' => $request->product_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product added to wishlist successfully'
        ]);
    }

    public function remove($productId)
    {
        $removed = auth()->user()->wishlists()
            ->where('product_id', $productId)
            ->delete();

        if (!$removed) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in wishlist'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product removed from wishlist'
        ]);
    }

    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $wishlist = auth()->user()->wishlists()
            ->where('product_id', $request->product_id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $message = 'Product removed from wishlist';
            $inWishlist = false;
        } else {
            auth()->user()->wishlists()->create([
                'product_id' => $request->product_id
            ]);
            $message = 'Product added to wishlist';
            $inWishlist = true;
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'in_wishlist' => $inWishlist
        ]);
    }
}
