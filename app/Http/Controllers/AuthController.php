<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;
use App\Events\UserRegistered;

class AuthController extends Controller
{
    /**
     * Hiển thị form đăng ký
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Xử lý đăng ký người dùng
     */
    public function register(Request $request)
    {
        // Validate dữ liệu
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Tên không được để trống',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Mật khẩu không được để trống',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Tạo user mới
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer', // Mặc định là customer
        ]);

        // Gửi email xác thực
        $user->sendEmailVerificationNotification();
        
        // Kích hoạt event để gửi email chào mừng
        event(new UserRegistered($user));

        // Đăng nhập ngay sau khi đăng ký
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Đăng ký thành công! Vui lòng kiểm tra email để xác thực tài khoản và email chào mừng.');
    }

    /**
     * Hiển thị form đăng nhập
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Xử lý đăng nhập người dùng
     */
    public function login(Request $request)
    {
        // Validate dữ liệu
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Mật khẩu không được để trống',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Cập nhật thời gian đăng nhập cuối
            Auth::user()->update(['last_login_at' => now()]);

            $request->session()->regenerate();

            // Kiểm tra role và điều hướng
            if (Auth::user()->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Đăng nhập thành công!');
            }

            return redirect()->intended(route('home'))->with('success', 'Đăng nhập thành công!');
        }

        return redirect()->back()
            ->withErrors(['email' => 'Thông tin đăng nhập không chính xác'])
            ->withInput($request->except('password'));
    }

    /**
     * Xử lý đăng xuất người dùng
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Đăng xuất thành công!');
    }
}