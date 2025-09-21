<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Constructor - Apply middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display user's wishlist
     */
    public function index()
    {
        $wishlistItems = Wishlist::forUser(Auth::id())
            ->with(['product' => function($query) {
                $query->active()->inStock();
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('wishlist.index', compact('wishlistItems'));
    }

    /**
     * Add product to wishlist
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $product = Product::findOrFail($request->product_id);
        
        $added = Wishlist::addToWishlist(Auth::id(), $product->id);

        if ($added->wasRecentlyCreated) {
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm sản phẩm vào danh sách yêu thích',
                'in_wishlist' => true
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Sản phẩm đã có trong danh sách yêu thích',
                'in_wishlist' => true
            ]);
        }
    }

    /**
     * Remove product from wishlist
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $removed = Wishlist::removeFromWishlist(Auth::id(), $request->product_id);

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa sản phẩm khỏi danh sách yêu thích',
            'in_wishlist' => false
        ]);
    }

    /**
     * Toggle product in wishlist
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $productId = $request->product_id;
        $userId = Auth::id();

        if (Wishlist::isInWishlist($userId, $productId)) {
            // Remove from wishlist
            Wishlist::removeFromWishlist($userId, $productId);
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa khỏi danh sách yêu thích',
                'in_wishlist' => false,
                'action' => 'removed'
            ]);
        } else {
            // Add to wishlist
            Wishlist::addToWishlist($userId, $productId);
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm vào danh sách yêu thích',
                'in_wishlist' => true,
                'action' => 'added'
            ]);
        }
    }

    /**
     * Get wishlist count for AJAX
     */
    public function count()
    {
        $count = Wishlist::forUser(Auth::id())->count();
        
        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }

    /**
     * Check if product is in wishlist
     */
    public function check(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        $inWishlist = Wishlist::isInWishlist(Auth::id(), $request->product_id);

        return response()->json([
            'success' => true,
            'in_wishlist' => $inWishlist
        ]);
    }
}