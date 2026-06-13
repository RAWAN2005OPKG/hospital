<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with("user", "specialty", "department")->paginate(12);
        return view("doctors.index", compact("doctors"));
    }

    public function show(Doctor $doctor)
    {
        $doctor->load("user", "specialty", "department", "schedules");
        return view("doctors.show", compact("doctor"));
    }

    // Admin methods for managing doctors
    public function create()
    {
        $specializations = Specialty::all();
        $departments = Department::all();

        return view('admin.doctors.create', compact('specializations', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:users",
            "phone" => "required|string|max:20|unique:users",
            "password" => "required|string|min:8|confirmed",
            'specialization_id' => 'required|exists:specializations,id',
            "department_id" => "required|exists:departments,id",
            "license_number" => "required|string|max:255|unique:doctors",
            "experience_years" => "required|integer|min:0",
            "bio" => "nullable|string",
            "consultation_fee" => "required|numeric|min:0",
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "password" => Hash::make($request->password),
            "role" => UserRoleEnum::Doctor,
        ]);

        Doctor::create([
            'user_id' => $user->id,
            'specialization_id' => $request->specialization_id,
            'department_id' => $request->department_id,
            'license_number' => $request->license_number,
            'experience_years' => $request->experience_years,
            'bio' => $request->bio,
            'consultation_fee' => $request->consultation_fee,
            'availability_status' => true,
        ]);

        return redirect()->route("admin.doctors")->with("success", "تم إضافة الطبيب بنجاح.");
    }

    public function edit(Doctor $doctor)
    {
        $specializations = Specialty::all();
        $departments = Department::all();

        return view('admin.doctors.edit', compact('doctor', 'specializations', 'departments'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "email" => "required|string|email|max:255|unique:users,email," . $doctor->user->id,
            "phone" => "required|string|max:20|unique:users,phone," . $doctor->user->id,
            'specialization_id' => 'required|exists:specializations,id',
            "department_id" => "required|exists:departments,id",
            "license_number" => "required|string|max:255|unique:doctors,license_number," . $doctor->id,
            "experience_years" => "required|integer|min:0",
            "bio" => "nullable|string",
            "consultation_fee" => "required|numeric|min:0",
            "availability_status" => "boolean",
        ]);

        $doctor->user->update([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
        ]);

        $doctor->update([
            'specialization_id' => $request->specialization_id,
            'department_id' => $request->department_id,
            'license_number' => $request->license_number,
            'experience_years' => $request->experience_years,
            'bio' => $request->bio,
            'consultation_fee' => $request->consultation_fee,
            'availability_status' => $request->availability_status ?? false,
        ]);

        return redirect()->route("admin.doctors")->with("success", "تم تحديث بيانات الطبيب بنجاح.");
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->user->delete(); // This will also delete the doctor record due to cascade on user_id
        return redirect()->route("admin.doctors")->with("success", "تم حذف الطبيب بنجاح.");
    }
}