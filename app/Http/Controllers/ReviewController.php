<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Constructor - Apply middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display user's reviews
     */
    public function index()
    {
        $reviews = Review::where('user_id', Auth::id())
            ->with(['product', 'order'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('reviews.index', compact('reviews'));
    }

    /**
     * Show form to create review for a product
     */
    public function create(Request $request)
    {
        $productId = $request->get('product_id');
        $orderId = $request->get('order_id');

        $product = Product::findOrFail($productId);
        
        // Check if user has purchased this product
        $hasPurchased = false;
        $order = null;
        
        if ($orderId) {
            $order = Order::where('id', $orderId)
                ->where('user_id', Auth::id())
                ->whereHas('orderItems', function($query) use ($productId) {
                    $query->where('product_id', $productId);
                })
                ->first();
            
            if ($order && in_array($order->status, ['delivered'])) {
                $hasPurchased = true;
            }
        } else {
            // Check if user has any delivered order with this product
            $hasPurchased = Order::where('user_id', Auth::id())
                ->where('status', 'delivered')
                ->whereHas('orderItems', function($query) use ($productId) {
                    $query->where('product_id', $productId);
                })
                ->exists();
        }

        // Check if user has already reviewed this product
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($existingReview) {
            return redirect()->route('products.show', $product->slug)
                ->with('error', 'Bạn đã đánh giá sản phẩm này rồi.');
        }

        return view('reviews.create', compact('product', 'order', 'hasPurchased'));
    }

    /**
     * Store a review
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'nullable|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string|max:1000'
        ], [
            'product_id.required' => 'Sản phẩm không tồn tại',
            'rating.required' => 'Vui lòng chọn số sao đánh giá',
            'rating.min' => 'Đánh giá tối thiểu 1 sao',
            'rating.max' => 'Đánh giá tối đa 5 sao',
            'comment.required' => 'Vui lòng nhập nội dung đánh giá',
            'comment.max' => 'Nội dung đánh giá không được quá 1000 ký tự'
        ]);

        // Check if user has already reviewed this product
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi.');
        }

        // Verify purchase if order_id is provided
        $verifiedPurchase = false;
        if ($request->order_id) {
            $order = Order::where('id', $request->order_id)
                ->where('user_id', Auth::id())
                ->where('status', 'delivered')
                ->whereHas('orderItems', function($query) use ($request) {
                    $query->where('product_id', $request->product_id);
                })
                ->first();
            
            if ($order) {
                $verifiedPurchase = true;
            }
        }

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'order_id' => $request->order_id,
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'verified_purchase' => $verifiedPurchase,
            'is_approved' => true // Auto approve for now
        ]);

        $product = Product::find($request->product_id);
        
        return redirect()->route('products.show', $product->slug)
            ->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }

    /**
     * Show specific review
     */
    public function show(Review $review)
    {
        // Only show user's own review or approved reviews
        if ($review->user_id !== Auth::id() && !$review->is_approved) {
            abort(404);
        }

        $review->load(['product', 'user', 'order']);
        
        return view('reviews.show', compact('review'));
    }

    /**
     * Show form to edit review
     */
    public function edit(Review $review)
    {
        // Only allow editing own reviews
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $review->load('product');
        
        return view('reviews.edit', compact('review'));
    }

    /**
     * Update review
     */
    public function update(Request $request, Review $review)
    {
        // Only allow updating own reviews
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'required|string|max:1000'
        ]);

        $review->update([
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'is_approved' => true // Keep approved status
        ]);

        return redirect()->route('reviews.show', $review)
            ->with('success', 'Đánh giá đã được cập nhật!');
    }

    /**
     * Delete review
     */
    public function destroy(Review $review)
    {
        // Only allow deleting own reviews
        if ($review->user_id !== Auth::id()) {
            abort(403);
        }

        $productSlug = $review->product->slug;
        $review->delete();

        return redirect()->route('products.show', $productSlug)
            ->with('success', 'Đánh giá đã được xóa!');
    }
}