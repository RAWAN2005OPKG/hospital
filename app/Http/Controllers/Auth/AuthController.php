<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public const DEMO_OTP = '123456';

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);

        $user = User::query()
            ->where('email', $request->email)
            ->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'identifier' => __('auth.failed'),
            ]);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return $this->redirectAfterLogin($user);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:patient,doctor,admin',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => UserRoleEnum::from($request->role),
        ]);

        if ($request->role === UserRoleEnum::Patient->value) {
            Patient::create([
                'user_id' => $user->id,
            ]);
        } elseif ($request->role === UserRoleEnum::Doctor->value) {
            // الحصول على أول قسم وتخصص متاح، أو إنشاء قيم افتراضية
            $department = Department::first();
            $specialization = Specialization::first();
            
            // إذا لم توجد أقسام، سيتم إنشاء قسم افتراضي
            if (!$department) {
                $department = Department::create([
                    'name' => 'قسم عام',
                    'description' => 'قسم افتراضي للأطباء الجدد',
                    'manager_name' => 'مدير النظام'
                ]);
            }
            
            // إذا لم توجد تخصصات، سيتم إنشاء تخصص افتراضي
            if (!$specialization) {
                $specialization = Specialization::create([
                    'name' => 'تخصص عام',
                    'description' => 'تخصص افتراضي للأطباء الجدد'
                ]);
            }
            
            Doctor::create([
                'user_id' => $user->id,
                'specialization_id' => $specialization->id,
                'license_number' => 'TEMP-' . $user->id,
                'experience_years' => 0,
                'bio' => '',
                'availability_status' => true,
                'consultation_fee' => 0,
                'department_id' => $department->id,
            ]);
        }

        Auth::login($user);

        return $this->redirectAfterLogin($user);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function redirectAfterLogin(User $user): \Illuminate\Http\RedirectResponse
    {
        if ($user->isStaff()) {
            return redirect()->intended(route('admin.dashboard'));
        }
        if ($user->isDoctor()) {
            return redirect()->intended(route('doctor.dashboard'));
        }

        return redirect()->intended(route('patient.dashboard'));
    }
}
