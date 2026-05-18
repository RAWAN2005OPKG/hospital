<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Specialty;

class SpecialtyController extends Controller
{
    public function index()
    {
        $specialties = Specialty::paginate(10);
        return view("admin.specialties.index", compact("specialties"));
    }

    public function create()
    {
        return view("admin.specialties.create");
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255|unique:specialties,name",
            "description" => "nullable|string",
        ]);

        Specialty::create($request->all());

        return redirect()->route("admin.specialties.index")->with("success", "تم إضافة التخصص بنجاح.");
    }

    public function edit(Specialty $specialty)
    {
        return view("admin.specialties.edit", compact("specialty"));
    }

    public function update(Request $request, Specialty $specialty)
    {
        $request->validate([
            "name" => "required|string|max:255|unique:specialties,name," . $specialty->id,
            "description" => "nullable|string",
        ]);

        $specialty->update($request->all());

        return redirect()->route("admin.specialties.index")->with("success", "تم تحديث التخصص بنجاح.");
    }

    public function destroy(Specialty $specialty)
    {
        $specialty->delete();
        return redirect()->route("admin.specialties.index")->with("success", "تم حذف التخصص بنجاح.");
    }
}