<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Email verification routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('home')->with('success', 'Email đã được xác thực thành công!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (\Illuminate\Http\Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', 'Email xác thực đã được gửi lại!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Product routes
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('index');
    Route::get('/search', [ProductController::class, 'search'])->name('search');
    Route::get('/category/{categorySlug}', [ProductController::class, 'byCategory'])->name('category');
    Route::get('/books', [CategoryController::class, 'showBooks'])->name('books');
    Route::get('/home-living', [CategoryController::class, 'showHomeLiving'])->name('home-living');
    Route::get('/{slug}', [ProductController::class, 'show'])->name('show');
});

// Category routes
Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/{slug}', [CategoryController::class, 'show'])->name('show');
});

// Category Product routes - Specific categories
Route::prefix('danh-muc')->name('category.')->group(function () {
    // Danh mục sách
    Route::get('/sach', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'sach')->name('sach');
    
    // Danh mục nhà cửa - đời sống  
    Route::get('/nha-cua', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'nha-cua')->name('nha-cua');
    
    // Danh mục điện thoại
    Route::get('/dien-thoai', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'dien-thoai')->name('dien-thoai');
    
    // Danh mục mẹ và bé
    Route::get('/me-be', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'me-be')->name('me-be');
    
    // Danh mục thiết bị số
    Route::get('/thiet-bi-so', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'thiet-bi-so')->name('thiet-bi-so');
    
    // Danh mục điện gia dụng
    Route::get('/dien-gia-dung', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'dien-gia-dung')->name('dien-gia-dung');
    
    // Danh mục làm đẹp
    Route::get('/lam-dep', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'lam-dep')->name('lam-dep');
    
    // Danh mục xe cộ
    Route::get('/xe-co', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'xe-co')->name('xe-co');
    
    // Danh mục thời trang nữ
    Route::get('/thoi-trang-nu', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'thoi-trang-nu')->name('thoi-trang-nu');
    
    // Danh mục bách hóa
    Route::get('/bach-hoa', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'bach-hoa')->name('bach-hoa');
    
    // Danh mục thể thao
    Route::get('/the-thao', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'the-thao')->name('the-thao');
    
    // Danh mục thời trang nam
    Route::get('/thoi-trang-nam', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'thoi-trang-nam')->name('thoi-trang-nam');
    
    // Danh mục cross border
    Route::get('/cross-border', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'cross-border')->name('cross-border');
    
    // Danh mục laptop
    Route::get('/laptop', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'laptop')->name('laptop');
    
    // Danh mục giày dép nam
    Route::get('/giay-dep-nam', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'giay-dep-nam')->name('giay-dep-nam');
    
    // Danh mục điện tử điện lạnh
    Route::get('/dien-tu-dien-lanh', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'dien-tu-dien-lanh')->name('dien-tu-dien-lanh');
    
    // Danh mục giày dép nữ
    Route::get('/giay-dep-nu', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'giay-dep-nu')->name('giay-dep-nu');
    
    // Danh mục máy ảnh
    Route::get('/may-anh', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'may-anh')->name('may-anh');
    
    // Danh mục phụ kiện thời trang
    Route::get('/phu-kien-thoi-trang', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'phu-kien-thoi-trang')->name('phu-kien-thoi-trang');
    
    // Danh mục voucher dịch vụ
    Route::get('/voucher-dich-vu', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'voucher-dich-vu')->name('voucher-dich-vu');
    
    // Danh mục thực phẩm
    Route::get('/thuc-pham', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'thuc-pham')->name('thuc-pham');
    
    // Danh mục thú cưng
    Route::get('/thu-cung', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'thu-cung')->name('thu-cung');
    
    // Danh mục dụng cụ thiết bị
    Route::get('/dung-cu-thiet-bi', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'dung-cu-thiet-bi')->name('dung-cu-thiet-bi');
    
    // Danh mục văn phòng phẩm
    Route::get('/van-phong-pham', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'van-phong-pham')->name('van-phong-pham');
    
    // Danh mục cây cảnh
    Route::get('/cay-canh', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'cay-canh')->name('cay-canh');
    
    // Danh mục quà tặng
    Route::get('/qua-tang', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'qua-tang')->name('qua-tang');
    
    // Danh mục du lịch
    Route::get('/du-lich', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'du-lich')->name('du-lich');
    
    // Danh mục gym
    Route::get('/gym', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'gym')->name('gym');
    
    // Danh mục câu cá
    Route::get('/cau-ca', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'cau-ca')->name('cau-ca');
    
    // Danh mục leo núi
    Route::get('/leo-nui', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'leo-nui')->name('leo-nui');
    
    // Danh mục bơi lội
    Route::get('/boi-loi', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'boi-loi')->name('boi-loi');
    
    // Danh mục xe đạp thể thao
    Route::get('/xe-dap-the-thao', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'xe-dap-the-thao')->name('xe-dap-the-thao');
    
    // Danh mục trò chơi trí tuệ
    Route::get('/tro-choi-tri-tue', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'tro-choi-tri-tue')->name('tro-choi-tri-tue');
    
    // Danh mục nghệ thuật thủ công
    Route::get('/nghe-thuat-thu-cong', [CategoryProductController::class, 'showCategory'])->defaults('categorySlug', 'nghe-thuat-thu-cong')->name('nghe-thuat-thu-cong');
});

// Cart routes
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::put('/update/{item}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{item}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'count'])->name('count');
});

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    // Legacy profile route (redirect to user.profile)
    Route::get('/profile', function() {
        return redirect()->route('user.profile');
    })->name('profile');
    // Order routes
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::patch('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');
    });
    
    // User dashboard and profile routes
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
        Route::get('/change-password', [UserController::class, 'changePasswordForm'])->name('change-password');
        Route::put('/change-password', [UserController::class, 'updatePassword'])->name('update-password');
        Route::get('/orders', [UserController::class, 'orderHistory'])->name('orders');
        Route::get('/reviews', [UserController::class, 'reviews'])->name('reviews');
        Route::get('/browse-history', [UserController::class, 'browseHistory'])->name('browse-history');
        Route::delete('/browse-history', [UserController::class, 'clearBrowseHistory'])->name('clear-browse-history');
    });

    // Review routes
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('index');
        Route::get('/create', [ReviewController::class, 'create'])->name('create');
        Route::post('/', [ReviewController::class, 'store'])->name('store');
        Route::get('/{review}', [ReviewController::class, 'show'])->name('show');
        Route::get('/{review}/edit', [ReviewController::class, 'edit'])->name('edit');
        Route::put('/{review}', [ReviewController::class, 'update'])->name('update');
        Route::delete('/{review}', [ReviewController::class, 'destroy'])->name('destroy');
    });
});

// Admin routes (require admin role)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User management
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::patch('/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle-status');
    Route::patch('/users/{user}/change-role', [AdminController::class, 'changeUserRole'])->name('users.change-role');
    
    // Admin product management
    Route::resource('products', ProductController::class)->except(['show'])->parameters([
        'products' => 'product'
    ]);
    
    // Admin category management  
    Route::resource('categories', CategoryController::class)->except(['show'])->parameters([
        'categories' => 'category'
    ]);
    
    // Admin order management
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminController::class, 'ordersList'])->name('index');
        Route::get('/{order}', [AdminController::class, 'orderShow'])->name('show');
        Route::patch('/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('update-status');
        Route::patch('/{order}/payment', [AdminController::class, 'updatePaymentStatus'])->name('update-payment');
    });
});

// Wishlist routes (requires authentication)
Route::middleware('auth')->prefix('wishlist')->name('wishlist.')->group(function () {
    Route::get('/', [WishlistController::class, 'index'])->name('index');
    Route::post('/add', [WishlistController::class, 'add'])->name('add');
    Route::delete('/remove', [WishlistController::class, 'remove'])->name('remove');
    Route::post('/toggle', [WishlistController::class, 'toggle'])->name('toggle');
    Route::get('/count', [WishlistController::class, 'count'])->name('count');
    Route::get('/check', [WishlistController::class, 'check'])->name('check');
});
