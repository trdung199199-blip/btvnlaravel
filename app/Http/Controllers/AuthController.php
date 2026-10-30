<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Mail\ResetPassword;
use App\Mail\WelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed', 
        ]);

        $user = User::create([
            'name' => $request->name,
            'email'  => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Log::info("Đăng ký thành công tài khoản: {$user->email}");
        Mail::to($user->email)->send(new WelcomeMail($user));
        Auth::login($user);

        return redirect('/posts')->with('success', 'Đăng ký tài khoản thành công!');
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            Log::info('Login success', ['user'=> Auth::user()]);
            return redirect()->intended('/posts');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
    public function showRegister()
    {
        return view('auth.register');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('post.index');
    }

    public function forgotPassword()
    {
        return view('auth.forgot_password');
    }
    public function processForgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.exists' => 'Email này chưa được đăng ký trong hệ thống.'
        ]);

        $user = User::where('email', $request->email)->first();
        $newPassword = Str::random(8);
        $user->password = Hash::make($newPassword);
        $user->save();

        Log::info("Đã cấp lại mật khẩu mới cho tài khoản: {$user->email}");

        Mail::to($user->email)->send(new ResetPassword($user, $newPassword));
        return redirect()->route('login')->with('success', 'Mật khẩu mới đã được gửi vào email của bạn. Vui lòng kiểm tra!');
    }
}
