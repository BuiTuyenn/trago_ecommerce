<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the cart
     */
    public function index()
    {
        $cart = $this->getCart();
        
        if (!$cart) {
            return view('cart.index', ['cartItems' => collect(), 'total' => 0]);
        }
        
        $cartItems = $cart->cartItems()->with('product')->get();
        $total = $cartItems->sum('total_price');
        
        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Check stock
        if (!$product->in_stock || $product->stock_quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Product is out of stock or insufficient quantity'
            ], 400);
        }

        $cart = $this->getOrCreateCart();
        
        // Check if product already exists in cart
        $cartItem = $cart->cartItems()->where('product_id', $product->id)->first();
        
        if ($cartItem) {
            // Update quantity
            $newQuantity = $cartItem->quantity + $request->quantity;
            
            // Check stock again
            if ($product->stock_quantity < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock for requested quantity'
                ], 400);
            }
            
            $cartItem->update([
                'quantity' => $newQuantity,
                'unit_price' => $product->effective_price
            ]);
        } else {
            // Create new cart item
            $cart->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'unit_price' => $product->effective_price
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart successfully',
            'cart_count' => $cart->total_items
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = $this->getCart();
        
        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Cart not found'], 404);
        }

        $cartItem = $cart->cartItems()->findOrFail($itemId);
        $product = $cartItem->product;

        // Check stock
        if ($product->stock_quantity < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock for requested quantity'
            ], 400);
        }

        $cartItem->update([
            'quantity' => $request->quantity,
            'unit_price' => $product->effective_price
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'item_total' => $cartItem->total_price,
            'cart_total' => $cart->total_price
        ]);
    }

    /**
     * Remove item from cart
     */
    public function remove($itemId)
    {
        $cart = $this->getCart();
        
        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Cart not found'], 404);
        }

        $cartItem = $cart->cartItems()->findOrFail($itemId);
        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'cart_total' => $cart->fresh()->total_price,
            'cart_count' => $cart->fresh()->total_items
        ]);
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        $cart = $this->getCart();
        
        if ($cart) {
            $cart->cartItems()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully'
        ]);
    }

    /**
     * Get cart count for AJAX requests
     */
    public function count()
    {
        $cart = $this->getCart();
        $count = $cart ? $cart->total_items : 0;

        return response()->json(['count' => $count]);
    }

    /**
     * Get current user's cart
     */
    private function getCart()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->first();
        } else {
            return Cart::where('session_id', session()->getId())->first();
        }
    }

    /**
     * Get or create cart for current user/session
     */
    private function getOrCreateCart()
    {
        if (Auth::check()) {
            return Cart::getOrCreate(Auth::id());
        } else {
            return Cart::getOrCreate(null, session()->getId());
        }
    }
}
