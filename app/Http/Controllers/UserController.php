<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Review;
use App\Models\BrowseHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Constructor - Apply middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display user profile
     */
    public function profile()
    {
        $user = Auth::user();
        $user->load(['orders', 'reviews', 'wishlist']);
        
        $stats = [
            'total_orders' => $user->orders->count(),
            'completed_orders' => $user->orders->where('status', 'delivered')->count(),
            'total_reviews' => $user->reviews->count(),
            'wishlist_items' => $user->wishlist->count(),
        ];

        return view('user.profile', compact('user', 'stats'));
    }

    /**
     * Show form to edit profile
     */
    public function editProfile()
    {
        $user = Auth::user();
        return view('user.edit-profile', compact('user'));
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'name.required' => 'Tên không được để trống',
            'phone.max' => 'Số điện thoại không được quá 20 ký tự',
            'date_of_birth.before' => 'Ngày sinh phải trước ngày hôm nay',
            'avatar.image' => 'Avatar phải là file hình ảnh',
            'avatar.max' => 'Avatar không được lớn hơn 2MB'
        ]);

        $data = $request->only([
            'name', 'first_name', 'last_name', 'phone', 
            'date_of_birth', 'gender'
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
        }

        $user->update($data);

        return redirect()->route('user.profile')
            ->with('success', 'Thông tin cá nhân đã được cập nhật!');
    }

    /**
     * Show form to change password
     */
    public function changePasswordForm()
    {
        return view('user.change-password');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại',
            'password.required' => 'Vui lòng nhập mật khẩu mới',
            'password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp'
        ]);

        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('user.profile')
            ->with('success', 'Mật khẩu đã được thay đổi thành công!');
    }

    /**
     * Display user's order history
     */
    public function orderHistory()
    {
        $orders = Auth::user()->orders()
            ->with('orderItems.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.order-history', compact('orders'));
    }

    /**
     * Display user's reviews
     */
    public function reviews()
    {
        $reviews = Auth::user()->reviews()
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.reviews', compact('reviews'));
    }

    /**
     * Display user's browse history
     */
    public function browseHistory()
    {
        $history = BrowseHistory::getRecentProducts(20);
        
        return view('user.browse-history', compact('history'));
    }

    /**
     * Clear browse history
     */
    public function clearBrowseHistory()
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        BrowseHistory::where(function($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->delete();

        return redirect()->back()
            ->with('success', 'Lịch sử duyệt đã được xóa!');
    }

    /**
     * Display dashboard overview
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        $recentOrders = $user->orders()
            ->with('orderItems')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        $recentReviews = $user->reviews()
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $browseHistory = BrowseHistory::getRecentProducts(6);

        $stats = [
            'total_orders' => $user->orders->count(),
            'pending_orders' => $user->orders->where('status', 'pending')->count(),
            'completed_orders' => $user->orders->where('status', 'delivered')->count(),
            'total_spent' => $user->orders->where('status', 'delivered')->sum('total_amount'),
            'total_reviews' => $user->reviews->count(),
            'wishlist_items' => $user->wishlist->count(),
        ];

        return view('user.dashboard', compact('user', 'recentOrders', 'recentReviews', 'browseHistory', 'stats'));
    }
}