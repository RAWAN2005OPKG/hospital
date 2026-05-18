<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use App\Models\Doctor;
use App\Enums\UserRoleEnum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view("auth.login");
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        if (Auth::attempt(["email" => $request->email, "password" => $request->password], $request->remember)) {
            $request->session()->regenerate();

            // Redirect based on user role
            if (Auth::user()->isAdmin()) {
                return redirect()->intended(route("admin.dashboard"));
            } elseif (Auth::user()->isDoctor()) {
                return redirect()->intended(route("doctor.dashboard"));
            } else {
                return redirect()->intended(route("patient.dashboard"));
            }
        }

        throw ValidationException::withMessages([
            "email" => __("auth.failed"),
        ]);
    }

    public function showRegistrationForm()
    {
        return view("auth.register");
    }

    public function register(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:users",
            "phone" => "required|string|max:20|unique:users",
            "password" => "required|string|min:8|confirmed",
            "role" => "required|in:patient,doctor",
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "password" => Hash::make($request->password),
            "role" => $request->role,
        ]);

        if ($request->role === UserRoleEnum::Patient->value) {
            Patient::create([
                "user_id" => $user->id,
            ]);
        } elseif ($request->role === UserRoleEnum::Doctor->value) {
            Doctor::create([
                "user_id" => $user->id,
                // Default values, can be updated later by admin/doctor
                "specialty_id" => 1, // Assuming a default specialty exists
                "license_number" => "N/A",
                "experience_years" => 0,
                "bio" => "",
                "availability_status" => false,
                "consultation_fee" => 0,
                "department_id" => 1, // Assuming a default department exists
            ]);
        }

        Auth::login($user);

        if ($user->isAdmin()) {
            return redirect()->route("admin.dashboard");
        } elseif ($user->isDoctor()) {
            return redirect()->route("doctor.dashboard");
        } else {
            return redirect()->route("patient.dashboard");
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect("/");
    }
}