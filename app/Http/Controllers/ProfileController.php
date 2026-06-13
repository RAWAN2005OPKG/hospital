<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $user->load("patient", "doctor.specialty", "doctor.department");
        return view("profile.show", compact("user"));
    }

    public function edit()
    {
        $user = Auth::user();
        $user->load("patient", "doctor.specialty", "doctor.department");
        return view("profile.edit", compact("user"));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            "name" => "required|string|max:255",
            "email" => ["required", "string", "email", "max:255", Rule::unique("users")->ignore($user->id)],
            "phone" => ["required", "string", "max:20", Rule::unique("users")->ignore($user->id)],
            "address" => "nullable|string|max:255",
            "avatar" => "nullable|image|max:2048", // Max 2MB
        ]);

        $user->update([
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "address" => $request->address,
        ]);

        if ($request->hasFile("avatar")) {
            if ($user->avatar) {
                // Delete old avatar
                // Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file("avatar")->store("avatars", "public");
            $user->save();
        }

        if ($user->isPatient()) {
            $request->validate([
                "blood_type" => "nullable|string|max:10",
                "birth_date" => "nullable|date",
                "gender" => "nullable|in:male,female",
                "emergency_contact" => "nullable|string|max:255",
            ]);
            $user->patient->update($request->only(["blood_type", "birth_date", "gender", "emergency_contact"]));
        }

        if ($user->isDoctor()) {
            $request->validate([
                'specialization_id' => 'required|exists:specializations,id',
                "department_id" => "required|exists:departments,id",
                "license_number" => ["required", "string", "max:255", Rule::unique("doctors", "license_number")->ignore($user->doctor->id)],
                "experience_years" => "required|integer|min:0",
                "bio" => "nullable|string",
                "consultation_fee" => "required|numeric|min:0",
            ]);
            $user->doctor->update($request->only(['specialization_id', 'department_id', 'license_number', 'experience_years', 'bio', 'consultation_fee']));
        }

        return redirect()->route("profile.show")->with("success", "تم تحديث الملف الشخصي بنجاح.");
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            "current_password" => ["required", "current_password"],
            "password" => "required|string|min:8|confirmed",
        ]);

        Auth::user()->update([
            "password" => Hash::make($request->password),
        ]);

        return back()->with("success", "تم تحديث كلمة المرور بنجاح.");
    }
}