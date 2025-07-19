<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = $this->getCart();
        $cartItems = $cart ? $cart->items()->with('product')->get() : collect();
        
        return view('cart.index', compact('cart', 'cartItems'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check stock availability
        if (!$product->isInStock($request->quantity)) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock available'
            ]);
        }

        $cart = $this->getOrCreateCart();
        $cart->addItem($request->product_id, $request->quantity);

        $cartCount = $cart->total_quantity;

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully',
            'cart_count' => $cartCount
        ]);
    }

    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        $cart = $this->getCart();
        
        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Cart not found'
            ]);
        }

        $product = Product::findOrFail($productId);

        if ($request->quantity > 0) {
            // Check stock availability
            if (!$product->isInStock($request->quantity)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock available'
                ]);
            }
        }

        $cart->updateItem($productId, $request->quantity);

        $cartCount = $cart->fresh()->total_quantity;
        $cartTotal = $cart->fresh()->total_amount;

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'cart_count' => $cartCount,
            'cart_total' => number_format($cartTotal, 2)
        ]);
    }

    public function remove($productId)
    {
        $cart = $this->getCart();
        
        if (!$cart) {
            return response()->json([
                'success' => false,
                'message' => 'Cart not found'
            ]);
        }

        $cart->removeItem($productId);

        $cartCount = $cart->fresh()->total_quantity;

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart',
            'cart_count' => $cartCount
        ]);
    }

    public function clear()
    {
        $cart = $this->getCart();
        
        if ($cart) {
            $cart->clear();
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully',
            'cart_count' => 0
        ]);
    }

    public function count()
    {
        $cart = $this->getCart();
        $count = $cart ? $cart->total_quantity : 0;

        return response()->json(['count' => $count]);
    }

    private function getCart()
    {
        if (auth()->check()) {
            return auth()->user()->cart;
        }

        $sessionId = session()->getId();
        return Cart::where('session_id', $sessionId)->first();
    }

    private function getOrCreateCart()
    {
        if (auth()->check()) {
            return auth()->user()->getOrCreateCart();
        }

        $sessionId = session()->getId();
        return Cart::firstOrCreate(['session_id' => $sessionId]);
    }
}
