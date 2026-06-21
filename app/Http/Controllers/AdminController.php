<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Specialization;
use App\Models\Appointment;
use App\Models\Setting;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Enums\UserRoleEnum;

class AdminController extends Controller
{
    private function resolvePerPage(Request $request, string $modelClass): int
    {
        $perPage = $request->query("per_page", 15);

        if ($perPage === "all") {
            return max(1, $modelClass::count());
        }

        return in_array((int) $perPage, [10, 20, 30], true) ? (int) $perPage : 15;
    }

    public function dashboard()
    {
        $totalUsers = User::count();
        $totalDoctors = Doctor::count();
        $totalAppointments = Appointment::count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        $unreadMessages = ContactMessage::where('status', 'new')->count();
        
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
            "appointmentsPerMonth",
            "unreadMessages"
        ));
    }

    public function users(Request $request)
    {
        $perPage = $this->resolvePerPage($request, User::class);
        $users = User::orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->withQueryString();

        return view("admin.users", compact("users"));
    }

    public function createUser()
    {
        $roles = [
            UserRoleEnum::Admin,
            UserRoleEnum::Receptionist,
            UserRoleEnum::Doctor,
            UserRoleEnum::Patient,
        ];

        return view("admin.users.create", compact("roles"));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|max:255|unique:users,email",
            "password" => "required|string|min:8|confirmed",
            "phone" => "nullable|string|max:255",
            "role" => "required|in:admin,receptionist,doctor,patient",
            "avatar" => "nullable|image|mimes:jpg,jpeg,png,webp|max:2048",
        ]);

        $data = [
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            "phone" => $request->phone,
            "role" => $request->role,
        ];

        if ($request->hasFile("avatar")) {
            $data["avatar"] = $request->file("avatar")->store("avatars", "public");
        }

        User::create($data);

        return redirect()->route("admin.users")->with("success", "تم إضافة المستخدم بنجاح");
    }

    public function doctors()
    {
        $doctors = Doctor::with("user", "department", "specialization")->paginate(15);
        return view("admin.doctors", compact("doctors"));
    }

    public function appointments(Request $request)
    {
        $perPage = $this->resolvePerPage($request, Appointment::class);
        $appointments = Appointment::with("patient.user", "doctor.user")
            ->orderBy("appointment_date", "desc")
            ->paginate($perPage)
            ->withQueryString();
        
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
            'license_number' => 'required|string|unique:doctors,license_number',
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
            'license_number' => $request->license_number,
            'bio' => $request->bio,
        ]);

        return redirect()->route('admin.doctors')->with('success', 'تم إضافة الطبيب بنجاح');
    }
    
    public function editUser(User $user)
    {
        $roles = [
            UserRoleEnum::Admin,
            UserRoleEnum::Receptionist,
            UserRoleEnum::Doctor,
            UserRoleEnum::Patient,
        ];

        return view("admin.users.edit", compact("user", "roles"));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|max:255|unique:users,email," . $user->id,
            "password" => "nullable|string|min:8|confirmed",
            "phone" => "nullable|string|max:255",
            "role" => "required|in:admin,receptionist,doctor,patient",
            "avatar" => "nullable|image|mimes:jpg,jpeg,png,webp|max:2048",
        ]);

        $data = [
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "role" => $request->role,
        ];

        if ($request->filled("password")) {
            $data["password"] = Hash::make($request->password);
        }

        if ($request->hasFile("avatar")) {
            $newPath = $request->file("avatar")->store("avatars", "public");

            if ($user->avatar && Storage::disk("public")->exists($user->avatar)) {
                Storage::disk("public")->delete($user->avatar);
            }

            $data["avatar"] = $newPath;
        }

        $user->update($data);

        return redirect()->route("admin.users")->with("success", "تم تحديث المستخدم بنجاح");
    }

    public function destroyUser(User $user)
    {
        if ($user->avatar && Storage::disk("public")->exists($user->avatar)) {
            Storage::disk("public")->delete($user->avatar);
        }

        $user->delete();

        return back()->with("success", "تم حذف المستخدم");
    }

    public function editDoctor(Doctor $doctor)
    {
        $departments = Department::all();
        $specializations = Specialization::all();
        return view('admin.doctors.edit', compact('doctor', 'departments', 'specializations'));
    }

    public function updateDoctor(Request $request, Doctor $doctor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $doctor->user_id,
            'department_id' => 'required|exists:departments,id',
            'specialization_id' => 'required|exists:specializations,id',
            'license_number' => 'required|string|unique:doctors,license_number,' . $doctor->id,
            'experience_years' => 'required|integer|min:0',
        ]);

        $doctor->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        if ($request->filled('password')) {
            $doctor->user->update(['password' => Hash::make($request->password)]);
        }

        $doctor->update([
            'department_id' => $request->department_id,
            'specialization_id' => $request->specialization_id,
            'license_number' => $request->license_number,
            'experience_years' => $request->experience_years,
            'bio' => $request->bio,
        ]);

        return redirect()->route('admin.doctors')->with('success', 'تم تحديث بيانات الطبيب بنجاح');
    }

    public function destroyDoctor(Doctor $doctor)
    {
        $doctor->delete();
        return back()->with('success', 'تم حذف الطبيب');
    }
    
    public function contactMessages(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        if ($perPage === 'all') {
            $perPage = max(1, ContactMessage::count());
        } else {
            $perPage = in_array((int)$perPage, [10, 20], true) ? (int)$perPage : 10;
        }
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();
        $unreadCount = ContactMessage::where('status', 'new')->count();
        return view('admin.contact-messages', compact('messages', 'unreadCount'));
    }

    public function markContactMessageRead(ContactMessage $message)
    {
        if ($message->status === 'new') {
            $message->markAsRead();
        }
        return response()->json(['ok' => true]);
    }

    public function replyContactMessage(Request $request, ContactMessage $message)
    {
        $request->validate([
            'admin_reply' => 'required|string|max:5000',
        ]);
        $message->addReply($request->admin_reply);
        return redirect()->route('admin.contact-messages')->with('success', 'تم إرسال الرد بنجاح');
    }
}
