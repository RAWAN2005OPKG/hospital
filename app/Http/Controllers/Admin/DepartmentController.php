<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Storage;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::paginate(10);
        return view("admin.departments.index", compact("departments"));
    }

    public function create()
    {
        return view("admin.departments.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255|unique:departments,name",
            "description" => "nullable|string",
            "manager_name" => "required|string|max:255",
            "phone" => "required|string|max:255|unique:departments,phone",
            "image" => "nullable|image|mimes:jpg,jpeg,png,webp|max:2048",
        ]);

        $data = $request->only(["name", "description", "manager_name", "phone"]);

        if ($request->hasFile("image")) {
            $data["image"] = $request->file("image")->store("departments", "public");
        }

        Department::create($data);

        return redirect()->route("admin.departments.index")->with("success", "تم إضافة القسم بنجاح.");
    }

    public function edit(Department $department)
    {
        return view("admin.departments.edit", compact("department"));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            "name" => "required|string|max:255|unique:departments,name," . $department->id,
            "description" => "nullable|string",
            "manager_name" => "required|string|max:255",
            "phone" => "required|string|max:255|unique:departments,phone," . $department->id,
            "image" => "nullable|image|mimes:jpg,jpeg,png,webp|max:2048",
        ]);

        $data = $request->only(["name", "description", "manager_name", "phone"]);

        if ($request->hasFile("image")) {
            $newPath = $request->file("image")->store("departments", "public");

            if ($department->image && Storage::disk("public")->exists($department->image)) {
                Storage::disk("public")->delete($department->image);
            }

            $data["image"] = $newPath;
        }

        $department->update($data);

        return redirect()->route("admin.departments.index")->with("success", "تم تحديث القسم بنجاح.");
    }

    public function destroy(Department $department)
    {
        if ($department->image && Storage::disk("public")->exists($department->image)) {
            Storage::disk("public")->delete($department->image);
        }

        $department->delete();
        return redirect()->route("admin.departments.index")->with("success", "تم حذف القسم بنجاح.");
    }
}