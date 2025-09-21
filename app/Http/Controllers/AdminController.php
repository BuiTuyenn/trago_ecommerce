<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;

class AdminController extends Controller
{
    /**
     * Construct - Áp dụng middleware admin cho tất cả methods
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Hiển thị dashboard admin
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_categories' => Category::count(),
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Quản lý danh mục - chuyển hướng đến CategoryController
     */
    public function categories()
    {
        return redirect()->route('admin.categories.index');
    }

    /**
     * Quản lý sản phẩm - chuyển hướng đến ProductController  
     */
    public function products()
    {
        return redirect()->route('admin.products.index');
    }

    /**
     * Quản lý đơn hàng - chuyển hướng đến OrderController
     */
    public function orders()
    {
        return redirect()->route('admin.orders.index');
    }

    /**
     * Quản lý người dùng
     */
    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Hiển thị thông tin chi tiết người dùng
     */
    public function showUser(User $user)
    {
        $user->load(['orders', 'reviews']);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Cập nhật trạng thái người dùng (kích hoạt/vô hiệu hóa)
     */
    public function toggleUserStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);
        
        $status = $user->is_active ? 'kích hoạt' : 'vô hiệu hóa';
        return redirect()->back()->with('success', "Đã {$status} tài khoản {$user->name}");
    }

    /**
     * Thay đổi role của người dùng
     */
    public function changeUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,customer'
        ]);

        $user->update(['role' => $request->role]);
        
        return redirect()->back()->with('success', "Đã cập nhật quyền cho {$user->name}");
    }

    /**
     * Hiển thị danh sách đơn hàng
     */
    public function ordersList(Request $request)
    {
        $query = Order::with('user', 'orderItems');
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }
        
        // Search by order number or user name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }
        
        $orders = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Statistics
        $statistics = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_revenue' => Order::where('status', 'delivered')->sum('total_amount'),
            'today_orders' => Order::whereDate('created_at', today())->count(),
        ];
        
        return view('admin.orders.index', compact('orders', 'statistics'));
    }

    /**
     * Hiển thị chi tiết đơn hàng
     */
    public function orderShow(Order $order)
    {
        $order->load('user', 'orderItems.product');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateOrderStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $oldStatus = $order->status;
        $order->status = $request->status;

        // Update timestamps based on status
        if ($request->status === 'shipped' && $oldStatus !== 'shipped') {
            $order->shipped_at = now();
        } elseif ($request->status === 'delivered' && $oldStatus !== 'delivered') {
            $order->delivered_at = now();
            $order->payment_status = 'paid'; // Auto mark as paid when delivered
        }

        $order->save();

        return redirect()->back()->with('success', 'Đã cập nhật trạng thái đơn hàng thành công.');
    }

    /**
     * Cập nhật trạng thái thanh toán
     */
    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,paid,failed'
        ]);

        $order->update(['payment_status' => $request->payment_status]);

        return redirect()->back()->with('success', 'Đã cập nhật trạng thái thanh toán thành công.');
    }
}
