<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Constructor - Apply middleware
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of user's orders
     */
    public function index()
    {
        $orders = Auth::user()->orders()
            ->with('orderItems.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new order (checkout page)
     */
    public function create()
    {
        $cart = $this->getUserCart();
        
        if (!$cart || $cart->cartItems->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống. Vui lòng thêm sản phẩm trước khi đặt hàng.');
        }

        $cartItems = $cart->cartItems()->with('product')->get();
        $subtotal = $cartItems->sum('total_price');
        $shippingCost = $this->calculateShippingCost($subtotal);
        $taxAmount = $this->calculateTax($subtotal);
        $total = $subtotal + $shippingCost + $taxAmount;

        return view('orders.create', compact('cartItems', 'subtotal', 'shippingCost', 'taxAmount', 'total'));
    }

    /**
     * Store a newly created order
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Shipping address
            'shipping_first_name' => 'required|string|max:255',
            'shipping_last_name' => 'required|string|max:255',
            'shipping_address_1' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:255',
            'shipping_state' => 'required|string|max:255',
            'shipping_postcode' => 'required|string|max:20',
            'shipping_country' => 'required|string|max:255',
            'shipping_phone' => 'nullable|string|max:20',
            
            // Billing address
            'billing_first_name' => 'required|string|max:255',
            'billing_last_name' => 'required|string|max:255',
            'billing_address_1' => 'required|string|max:255',
            'billing_city' => 'required|string|max:255',
            'billing_state' => 'required|string|max:255',
            'billing_postcode' => 'required|string|max:20',
            'billing_country' => 'required|string|max:255',
            'billing_phone' => 'nullable|string|max:20',
            
            'payment_method' => 'required|string|in:cod,bank_transfer,credit_card',
            'notes' => 'nullable|string|max:1000',
        ], [
            'shipping_first_name.required' => 'Họ người nhận không được để trống',
            'shipping_last_name.required' => 'Tên người nhận không được để trống',
            'shipping_address_1.required' => 'Địa chỉ giao hàng không được để trống',
            'shipping_city.required' => 'Thành phố giao hàng không được để trống',
            'shipping_state.required' => 'Tỉnh/Thành phố không được để trống',
            'shipping_postcode.required' => 'Mã bưu điện không được để trống',
            'shipping_country.required' => 'Quốc gia không được để trống',
            'billing_first_name.required' => 'Họ người thanh toán không được để trống',
            'billing_last_name.required' => 'Tên người thanh toán không được để trống',
            'billing_address_1.required' => 'Địa chỉ thanh toán không được để trống',
            'billing_city.required' => 'Thành phố thanh toán không được để trống',
            'billing_state.required' => 'Tỉnh/Thành phố thanh toán không được để trống',
            'billing_postcode.required' => 'Mã bưu điện thanh toán không được để trống',
            'billing_country.required' => 'Quốc gia thanh toán không được để trống',
            'payment_method.required' => 'Vui lòng chọn phương thức thanh toán',
            'payment_method.in' => 'Phương thức thanh toán không hợp lệ',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $cart = $this->getUserCart();
        
        if (!$cart || $cart->cartItems->count() === 0) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
        }

        try {
            DB::beginTransaction();

            $cartItems = $cart->cartItems()->with('product')->get();
            $subtotal = $cartItems->sum('total_price');
            $shippingCost = $this->calculateShippingCost($subtotal);
            $taxAmount = $this->calculateTax($subtotal);
            $total = $subtotal + $shippingCost + $taxAmount;

            // Create order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => Auth::id(),
                'status' => 'pending',
                'subtotal' => $subtotal,
                'tax_amount' => $taxAmount,
                'shipping_cost' => $shippingCost,
                'total_amount' => $total,
                'currency' => 'VND',
                
                // Shipping address
                'shipping_first_name' => $request->shipping_first_name,
                'shipping_last_name' => $request->shipping_last_name,
                'shipping_company' => $request->shipping_company,
                'shipping_address_1' => $request->shipping_address_1,
                'shipping_address_2' => $request->shipping_address_2,
                'shipping_city' => $request->shipping_city,
                'shipping_state' => $request->shipping_state,
                'shipping_postcode' => $request->shipping_postcode,
                'shipping_country' => $request->shipping_country,
                'shipping_phone' => $request->shipping_phone,
                
                // Billing address
                'billing_first_name' => $request->billing_first_name,
                'billing_last_name' => $request->billing_last_name,
                'billing_company' => $request->billing_company,
                'billing_address_1' => $request->billing_address_1,
                'billing_address_2' => $request->billing_address_2,
                'billing_city' => $request->billing_city,
                'billing_state' => $request->billing_state,
                'billing_postcode' => $request->billing_postcode,
                'billing_country' => $request->billing_country,
                'billing_phone' => $request->billing_phone,
                
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'notes' => $request->notes,
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                // Kiểm tra stock còn đủ không
                if ($cartItem->product->stock_quantity < $cartItem->quantity) {
                    throw new \Exception("Sản phẩm {$cartItem->product->name} không đủ hàng trong kho.");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'product_sku' => $cartItem->product->sku,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $cartItem->unit_price,
                    'total_price' => $cartItem->total_price,
                ]);

                // Giảm stock quantity
                $cartItem->product->decrement('stock_quantity', $cartItem->quantity);
            }

            // Clear cart
            $cart->cartItems()->delete();

            DB::commit();

            return redirect()->route('orders.show', $order)->with('success', 'Đặt hàng thành công! Đơn hàng của bạn đang được xử lý.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi đặt hàng: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified order
     */
    public function show(Order $order)
    {
        // Ensure user can only view their own orders
        if ($order->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Bạn không có quyền xem đơn hàng này.');
        }

        $order->load('orderItems.product', 'user');

        return view('orders.show', compact('order'));
    }

    /**
     * Cancel an order
     */
    public function cancel(Order $order)
    {
        // Ensure user can only cancel their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Bạn không có quyền hủy đơn hàng này.');
        }

        if (!in_array($order->status, ['pending', 'processing'])) {
            return redirect()->back()->with('error', 'Không thể hủy đơn hàng này.');
        }

        try {
            DB::beginTransaction();

            // Restore stock quantities
            foreach ($order->orderItems as $item) {
                $item->product->increment('stock_quantity', $item->quantity);
            }

            // Update order status
            $order->update(['status' => 'cancelled']);

            DB::commit();

            return redirect()->back()->with('success', 'Đơn hàng đã được hủy thành công.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi hủy đơn hàng.');
        }
    }

    /**
     * Get user's cart
     */
    private function getUserCart()
    {
        return Cart::where('user_id', Auth::id())->first();
    }

    /**
     * Calculate shipping cost
     */
    private function calculateShippingCost($subtotal)
    {
        // Free shipping for orders over 500,000 VND
        if ($subtotal >= 500000) {
            return 0;
        }
        
        // Standard shipping cost
        return 30000;
    }

    /**
     * Calculate tax amount
     */
    private function calculateTax($subtotal)
    {
        // VAT 10%
        return $subtotal * 0.1;
    }
}