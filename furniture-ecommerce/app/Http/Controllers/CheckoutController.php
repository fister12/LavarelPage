<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart = auth()->user()->cart;
        
        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $cartItems = $cart->items()->with('product')->get();
        $addresses = auth()->user()->addresses;
        $defaultAddress = auth()->user()->defaultAddress;

        $subtotal = $cart->total_amount;
        $tax = $subtotal * 0.18; // 18% GST
        $shipping = $subtotal >= 10000 ? 0 : 500; // Free shipping over ₹10,000
        $total = $subtotal + $tax + $shipping;

        return view('checkout.index', compact(
            'cartItems',
            'addresses',
            'defaultAddress',
            'subtotal',
            'tax',
            'shipping',
            'total'
        ));
    }

    public function process(Request $request)
    {
        $request->validate([
            'shipping_address_id' => 'required|exists:addresses,id',
            'billing_address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|in:cod,razorpay,stripe',
            'notes' => 'nullable|string|max:500'
        ]);

        $cart = auth()->user()->cart;
        
        if (!$cart || $cart->items->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty'
            ]);
        }

        try {
            DB::beginTransaction();

            // Calculate totals
            $subtotal = $cart->total_amount;
            $tax = $subtotal * 0.18;
            $shipping = $subtotal >= 10000 ? 0 : 500;
            $total = $subtotal + $tax + $shipping;

            // Get addresses
            $shippingAddress = Address::findOrFail($request->shipping_address_id);
            $billingAddress = Address::findOrFail($request->billing_address_id);

            // Create order
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => Order::generateOrderNumber(),
                'status' => 'pending',
                'total_amount' => $total,
                'tax_amount' => $tax,
                'shipping_amount' => $shipping,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'cod' ? 'pending' : 'pending',
                'shipping_address' => $shippingAddress->toArray(),
                'billing_address' => $billingAddress->toArray(),
                'notes' => $request->notes
            ]);

            // Create order items
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->effective_price,
                    'product_name' => $item->product->name,
                    'product_sku' => $item->product->sku
                ]);

                // Update product stock
                $product = $item->product;
                if ($product->manage_stock) {
                    $product->decrement('stock_quantity', $item->quantity);
                }
            }

            // Clear cart
            $cart->clear();

            DB::commit();

            // Handle payment processing
            if ($request->payment_method === 'cod') {
                return response()->json([
                    'success' => true,
                    'redirect_url' => route('checkout.success', $order->id)
                ]);
            }

            // For online payments, return payment details
            return response()->json([
                'success' => true,
                'payment_required' => true,
                'order_id' => $order->id,
                'amount' => $total * 100, // Convert to paise for payment gateways
                'order_number' => $order->order_number
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your order. Please try again.'
            ]);
        }
    }

    public function success(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }
}
