<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Specialization;
use App\Models\Appointment;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Enums\UserRoleEnum;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalDoctors = Doctor::count();
        $totalAppointments = Appointment::count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        
        // Stats for chart
        $appointmentsPerMonth = Appointment::selectRaw('MONTH(appointment_date) as month, COUNT(*) as count')
            ->whereYear('appointment_date', date('Y'))
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();

        return view("admin.dashboard", compact(
            "totalUsers",
            "totalDoctors",
            "totalAppointments",
            "pendingAppointments",
            "appointmentsPerMonth"
        ));
    }

    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view("admin.users", compact("users"));
    }

    public function doctors()
    {
        $doctors = Doctor::with("user", "department", "specialization")->paginate(15);
        return view("admin.doctors", compact("doctors"));
    }

    public function appointments()
    {
        $appointments = Appointment::with("patient.user", "doctor.user")
            ->orderBy("appointment_date", "desc")
            ->paginate(15);
        
        $todayAppointments = Appointment::whereDate('appointment_date', now())->count();
        $weekAppointments = Appointment::whereBetween('appointment_date', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();

        return view("admin.appointments", compact(
            "appointments", 
            "todayAppointments", 
            "weekAppointments", 
            "pendingAppointments"
        ));
    }

    public function departments()
    {
        $departments = Department::withCount("doctors")->paginate(15);
        $specializations = Specialization::withCount("doctors")->paginate(15, ['*'], 'specs_page');
        return view("admin.departments", compact("departments", "specializations"));
    }

    public function settings()
    {
        $settings = Setting::first();
        if (!$settings) {
            $settings = new Setting();
            $settings->site_name = "مستشفى صحتي";
        }
        return view("admin.settings", compact("settings"));
    }

    public function updateSettings(Request $request)
    {
        $settings = Setting::first();
        if (!$settings) {
            $settings = new Setting();
        }

        $settings->site_name = $request->site_name;
        $settings->email = $request->email;
        $settings->phone = $request->phone;
        
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('settings', 'public');
            $settings->logo = $path;
        }

        $settings->social_links = $request->social_links;
        $settings->maintenance_mode = $request->has('maintenance_mode');
        $settings->save();

        return redirect()->back()->with('success', 'تم تحديث الإعدادات بنجاح');
    }

    public function createDoctor()
    {
        $departments = Department::all();
        $specializations = Specialization::all();
        return view("admin.doctors.create", compact("departments", "specializations"));
    }

    public function storeDoctor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'department_id' => 'required|exists:departments,id',
            'specialization_id' => 'required|exists:specializations,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => UserRoleEnum::Doctor,
            'phone' => $request->phone,
        ]);

        Doctor::create([
            'user_id' => $user->id,
            'department_id' => $request->department_id,
            'specialization_id' => $request->specialization_id,
            'experience_years' => $request->experience_years ?? 0,
            'bio' => $request->bio,
        ]);

        return redirect()->route('admin.doctors')->with('success', 'تم إضافة الطبيب بنجاح');
    }
    
    // Additional placeholder methods for users/doctors edit/delete to prevent errors
    public function editUser(User $user) { return view('admin.users.edit', compact('user')); }
    public function destroyUser(User $user) { $user->delete(); return back()->with('success', 'تم حذف المستخدم'); }
    public function editDoctor(Doctor $doctor) { return view('admin.doctors.edit', compact('doctor')); }
    public function destroyDoctor(Doctor $doctor) { $doctor->delete(); return back()->with('success', 'تم حذف الطبيب'); }
}

    public function contactMessages()
    {
        $messages = \App\Models\ContactMessage::orderBy('created_at', 'desc')->paginate(20);
        $unreadCount = \App\Models\ContactMessage::where('status', 'new')->count();
        return view("admin.contact-messages", compact("messages", "unreadCount"));
    }
