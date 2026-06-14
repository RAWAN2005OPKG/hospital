<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Department;
use App\Models\Specialization;
use App\Models\Appointment;
use App\Models\Setting;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Enums\UserRoleEnum;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = User::count();
        $totalDoctors = Doctor::count();
        $totalAppointments = Appointment::count();
        $pendingAppointments = Appointment::where("status", "pending")->count();

        // Example analytics data (can be expanded)
        $appointmentsPerMonth = Appointment::selectRaw("MONTH(appointment_date) as month, COUNT(*) as count")
            ->groupBy("month")
            ->orderBy("month")
            ->get();

        return view(
            "admin.dashboard",
            compact(
                "totalUsers",
                "totalDoctors",
                "totalAppointments",
                "pendingAppointments",
                "appointmentsPerMonth"
            )
        );
    }

    public function users()
    {
        $users = User::with("patient", "doctor")->paginate(15);
        return view("admin.users.index", compact("users"));
    }

    public function createUser()
    {
        return view("admin.users.create");
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email",
            "phone" => "required|string|unique:users,phone|regex:/^[0-9\+\-\s]{9,}$/",
            "password" => "required|string|min:8|confirmed",
            "role" => ["required", Rule::in([UserRoleEnum::Patient->value, UserRoleEnum::Doctor->value, UserRoleEnum::Admin->value])],
        ]);

        $user = User::create([
            "name" => $validated["name"],
            "email" => $validated["email"],
            "phone" => $validated["phone"],
            "password" => Hash::make($validated["password"]),
            "role" => UserRoleEnum::from($validated["role"]),
        ]);

        if ($user->isDoctor()) {
            Doctor::create(["user_id" => $user->id]); // Basic doctor entry, needs more fields
        } elseif ($user->isPatient()) {
            // Patient::create(['user_id' => $user->id]); // Create patient profile if needed
        }

        return redirect()
            ->route("admin.users.index")
            ->with("success", "تم إضافة المستخدم بنجاح");
    }

    public function editUser(User $user)
    {
        return view("admin.users.edit", compact("user"));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "email" => ["required", "email", Rule::unique("users", "email")->ignore($user->id)],
            "phone" => ["required", "string", Rule::unique("users", "phone")->ignore($user->id), "regex:/^[0-9\+\-\s]{9,}$/"],
            "role" => ["required", Rule::in([UserRoleEnum::Patient->value, UserRoleEnum::Doctor->value, UserRoleEnum::Admin->value])],
        ]);

        $user->update([
            "name" => $validated["name"],
            "email" => $validated["email"],
            "phone" => $validated["phone"],
            "role" => UserRoleEnum::from($validated["role"]),
        ]);

        return redirect()
            ->route("admin.users.index")
            ->with("success", "تم تحديث المستخدم بنجاح");
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()
            ->route("admin.users.index")
            ->with("success", "تم حذف المستخدم بنجاح");
    }

    public function doctors()
    {
        $doctors = Doctor::with("user", "specialization", "department")->paginate(15);
        return view("admin.doctors.index", compact("doctors"));
    }

    public function createDoctor()
    {
        $departments = Department::all();
        $specializations = Specialization::all();
        return view("admin.doctors.create", compact("departments", "specializations"));
    }

    public function storeDoctor(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|email|unique:users,email",
            "phone" => "required|string|unique:users,phone|regex:/^[0-9\+\-\s]{9,}$/",
            "password" => "required|string|min:8|confirmed",
            "license_number" => "required|string|unique:doctors,license_number",
            "specialization_id" => "required|exists:specializations,id",
            "department_id" => "required|exists:departments,id",
            "experience_years" => "nullable|integer|min:0",
            "bio" => "nullable|string",
            "consultation_fee" => "nullable|numeric|min:0",
            "photo" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
        ]);

        $user = User::create([
            "name" => $validated["name"],
            "email" => $validated["email"],
            "phone" => $validated["phone"],
            "password" => Hash::make($validated["password"]),
            "role" => UserRoleEnum::Doctor,
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('doctors', 'public');
        }

        Doctor::create([
            "user_id" => $user->id,
            "license_number" => $validated["license_number"],
            "specialization_id" => $validated["specialization_id"],
            "department_id" => $validated["department_id"],
            "experience_years" => $validated["experience_years"] ?? 0,
            "bio" => $validated["bio"],
            "consultation_fee" => $validated["consultation_fee"] ?? 0,
            "photo" => $photoPath,
        ]);

        return redirect()
            ->route("admin.doctors.index")
            ->with("success", "تم إضافة الطبيب بنجاح");
    }

    public function editDoctor(Doctor $doctor)
    {
        $doctor->load("user");
        $departments = Department::all();
        $specializations = Specialization::all();
        return view("admin.doctors.edit", compact("doctor", "departments", "specializations"));
    }

    public function updateDoctor(Request $request, Doctor $doctor)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255",
            "email" => ["required", "email", Rule::unique("users", "email")->ignore($doctor->user->id)],
            "phone" => ["required", "string", Rule::unique("users", "phone")->ignore($doctor->user->id), "regex:/^[0-9\+\-\s]{9,}$/"],
            "license_number" => ["required", "string", Rule::unique("doctors", "license_number")->ignore($doctor->id)],
            "specialization_id" => "required|exists:specializations,id",
            "department_id" => "required|exists:departments,id",
            "experience_years" => "nullable|integer|min:0",
            "bio" => "nullable|string",
            "consultation_fee" => "nullable|numeric|min:0",
            "photo" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
        ]);

        $doctor->user->update([
            "name" => $validated["name"],
            "email" => $validated["email"],
            "phone" => $validated["phone"],
        ]);

        $updateData = [
            "license_number" => $validated["license_number"],
            "specialization_id" => $validated["specialization_id"],
            "department_id" => $validated["department_id"],
            "experience_years" => $validated["experience_years"] ?? 0,
            "bio" => $validated["bio"],
            "consultation_fee" => $validated["consultation_fee"] ?? 0,
        ];

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('doctors', 'public');
            $updateData['photo'] = $photoPath;
        }

        $doctor->update($updateData);

        return redirect()
            ->route("admin.doctors.index")
            ->with("success", "تم تحديث بيانات الطبيب بنجاح");
    }

    public function destroyDoctor(Doctor $doctor)
    {
        $doctor->user->delete(); // This will also delete the doctor record due to cascade
        return redirect()
            ->route("admin.doctors.index")
            ->with("success", "تم حذف الطبيب بنجاح");
    }

    public function appointments()
    {
        $appointments = Appointment::with("patient.user", "doctor.user", "doctor.specialization")
            ->orderBy("appointment_date", "desc")
            ->paginate(15);
        return view("admin.appointments.index", compact("appointments"));
    }

    public function departments()
    {
        $departments = Department::withCount("doctors", "specializations")->paginate(15);
        return view("admin.departments.index", compact("departments"));
    }

    public function createDepartment()
    {
        return view("admin.departments.create");
    }

    public function storeDepartment(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255|unique:departments,name",
            "description" => "nullable|string",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('departments', 'public');
        }

        Department::create([
            "name" => $validated["name"],
            "description" => $validated["description"],
            "image" => $imagePath,
        ]);

        return redirect()
            ->route("admin.departments.index")
            ->with("success", "تم إضافة القسم بنجاح");
    }

    public function editDepartment(Department $department)
    {
        return view("admin.departments.edit", compact("department"));
    }

    public function updateDepartment(Request $request, Department $department)
    {
        $validated = $request->validate([
            "name" => ["required", "string", "max:255", Rule::unique("departments", "name")->ignore($department->id)],
            "description" => "nullable|string",
            "image" => "nullable|image|mimes:jpeg,png,jpg,gif|max:2048",
        ]);

        $updateData = [
            "name" => $validated["name"],
            "description" => $validated["description"],
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('departments', 'public');
            $updateData['image'] = $imagePath;
        }

        $department->update($updateData);

        return redirect()
            ->route("admin.departments.index")
            ->with("success", "تم تحديث القسم بنجاح");
    }

    public function destroyDepartment(Department $department)
    {
        if ($department->doctors()->exists() || $department->specializations()->exists()) {
            return redirect()
                ->back()
                ->with("error", "لا يمكن حذف القسم لوجود أطباء أو تخصصات مرتبطة به");
        }
        $department->delete();
        return redirect()
            ->route("admin.departments.index")
            ->with("success", "تم حذف القسم بنجاح");
    }

    public function specializations()
    {
        $specializations = Specialization::with("department")->withCount("doctors")->paginate(15);
        return view("admin.specializations.index", compact("specializations"));
    }

    public function createSpecialization()
    {
        $departments = Department::all();
        return view("admin.specializations.create", compact("departments"));
    }

    public function storeSpecialization(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|string|max:255|unique:specializations,name",
            "description" => "nullable|string",
            "department_id" => "required|exists:departments,id",
        ]);

        Specialization::create($validated);

        return redirect()
            ->route("admin.specializations.index")
            ->with("success", "تم إضافة التخصص بنجاح");
    }

    public function editSpecialization(Specialization $specialization)
    {
        $departments = Department::all();
        return view("admin.specializations.edit", compact("specialization", "departments"));
    }

    public function updateSpecialization(Request $request, Specialization $specialization)
    {
        $validated = $request->validate([
            "name" => ["required", "string", "max:255", Rule::unique("specializations", "name")->ignore($specialization->id)],
            "description" => "nullable|string",
            "department_id" => "required|exists:departments,id",
        ]);

        $specialization->update($validated);

        return redirect()
            ->route("admin.specializations.index")
            ->with("success", "تم تحديث التخصص بنجاح");
    }

    public function destroySpecialization(Specialization $specialization)
    {
        if ($specialization->doctors()->exists()) {
            return redirect()
                ->back()
                ->with("error", "لا يمكن حذف التخصص لوجود أطباء مرتبطين به");
        }
        $specialization->delete();
        return redirect()
            ->route("admin.specializations.index")
            ->with("success", "تم حذف التخصص بنجاح");
    }

    public function settings()
    {
        $settings = Setting::firstOrCreate([]);
        return view("admin.settings.index", compact("settings"));
    }

    public function updateSettings(Request $request)
    {
        $settings = Setting::firstOrCreate([]);

        $validated = $request->validate([
            "site_name" => "required|string|max:255",
            "logo" => "nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            "email" => "nullable|email",
            "phone" => "nullable|string",
            "maintenance_mode" => "boolean",
            "social_links.facebook" => "nullable|url",
            "social_links.twitter" => "nullable|url",
            "social_links.instagram" => "nullable|url",
            "social_links.linkedin" => "nullable|url",
        ]);

        if ($request->hasFile("logo")) {
            if ($settings->logo) {
                Storage::delete($settings->logo);
            }
            $validated["logo"] = $request->file("logo")->store("settings");
        }

        $settings->update($validated);

        return redirect()
            ->back()
            ->with("success", "تم تحديث الإعدادات بنجاح");
    }

    public function activityLogs()
    {
        $activityLogs = ActivityLog::with("user")
            ->orderBy("created_at", "desc")
            ->paginate(20);
        return view("admin.activity-logs.index", compact("activityLogs"));
    }
}