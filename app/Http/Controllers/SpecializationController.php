<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use App\Models\Department;
use Illuminate\Http\Request;

class SpecializationController extends Controller
{
    public function index()
    {
        $specializations = Specialization::withCount('doctors')->paginate(15);
        return view('admin.specializations.index', compact('specializations'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('admin.specializations.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:specializations,name|max:255',
            'description' => 'nullable|string',
        ]);

        Specialization::create($validated);

        return redirect()->route('admin.departments')->with('success', 'تم إضافة التخصص بنجاح');
    }

    public function edit(Specialization $specialization)
    {
        $departments = Department::all();
        return view('admin.specializations.edit', compact('specialization', 'departments'));
    }

    public function update(Request $request, Specialization $specialization)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:specializations,name,' . $specialization->id . '|max:255',
            'description' => 'nullable|string',
        ]);

        $specialization->update($validated);

        return redirect()->route('admin.departments')->with('success', 'تم تحديث التخصص بنجاح');
    }

    public function destroy(Specialization $specialization)
    {
        $specialization->delete();
        return redirect()->route('admin.departments')->with('success', 'تم حذف التخصص بنجاح');
    }
}
