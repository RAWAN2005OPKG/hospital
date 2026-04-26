<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // عرض صفحة التسجيل
    public function showRegister()
    {
        return view('auth.register');
    }

    // تسجيل مستخدم جديد
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone|regex:/^[0-9\+\-\s]{9,}$/',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:patient,doctor',
        ], [
            'name.required' => 'الاسم مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'email.unique' => 'هذا البريد مسجل بالفعل',
            'phone.required' => 'رقم الجوال مطلوب',
            'phone.unique' => 'هذا الرقم مسجل بالفعل',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min' => 'كلمة المرور يجب أن تكون 8 أحرف على الأقل',
            'password.confirmed' => 'كلمات المرور غير متطابقة',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        Auth::login($user);

        return redirect()->route('home')
            ->with('success', 'تم التسجيل بنجاح');
    }

    // عرض صفحة الدخول
    public function showLogin()
    {
        return view('auth.login');
    }

    // تسجيل الدخول
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'password.required' => 'كلمة المرور مطلوبة',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'))
                ->with('success', 'تم تسجيل الدخول بنجاح');
        }

        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة',
        ])->onlyInput('email');
    }

    // تسجيل الخروج
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')
            ->with('success', 'تم تسجيل الخروج بنجاح');
    }

    // إنشاء Admin من الويب
    public function createAdmin(Request $request)
    {
        // التحقق من أنه لا توجد admins بالفعل
        if (User::where('role', 'admin')->exists()) {
            return redirect()->route('home')
                ->with('error', 'يوجد admin بالفعل');
        }

        if ($request->method() === 'GET') {
            return view('auth.create-admin');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|unique:users,phone|regex:/^[0-9\+\-\s]{9,}$/',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Hash::make($validated['password']),
            'role' => 'admin',
        ]);

        Auth::login($admin);

        return redirect()->route('admin.dashboard')
            ->with('success', 'تم إنشاء حساب Admin بنجاح');
    }
}