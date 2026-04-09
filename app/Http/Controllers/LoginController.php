<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Kiểm tra nếu là admin thì vào trang quản trị, ngược lại về trang chủ
            if (Auth::user()->role === 'admin') {
                return redirect()->intended(route('admin.users.index')); // Chuyển hướng admin về trang quản lý người dùng
            }

            return redirect()->intended(route('admin.orders')); // Chuyển hướng người dùng thường về trang đơn hàng của họ
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {   
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}