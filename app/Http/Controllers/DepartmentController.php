<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    // عرض جميع الأقسام
    public function index()
    {
        $departments = Department::all();
        return view('admin.departments.index', compact('departments'));
    }

    // عرض صفحة إنشاء قسم جديد
    public function create()
    {
        return view('admin.departments.create');
    }

    // حفظ القسم الجديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:departments,name|max:255',
            'description' => 'nullable|string',
            'manager_name' => 'required|string|max:255',
            'phone' => 'required|string|unique:departments,phone|regex:/^[0-9\+\-\s]{9,}$/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'اسم القسم مطلوب',
            'name.unique' => 'هذا الاسم موجود بالفعل',
            'manager_name.required' => 'اسم المسؤول مطلوب',
            'phone.required' => 'رقم الجوال مطلوب',
            'phone.unique' => 'هذا الرقم موجود بالفعل',
            'image.image' => 'يجب أن تكون الصورة صحيحة',
            'image.mimes' => 'صيغ الصور المقبولة: jpeg, png, jpg, gif',
            'image.max' => 'حجم الصورة يجب أن لا يتجاوز 2MB',
        ]);

        // معالجة الصورة
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/departments'), $imageName);
            $validated['image'] = 'uploads/departments/' . $imageName;
        }

        Department::create($validated);

        return redirect()->route('admin.departments.index')
            ->with('success', 'تم إضافة القسم بنجاح');
    }

    // عرض صفحة تعديل القسم
    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    // تحديث القسم
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:departments,name,' . $department->id . '|max:255',
            'description' => 'nullable|string',
            'manager_name' => 'required|string|max:255',
            'phone' => 'required|string|unique:departments,phone,' . $department->id . '|regex:/^[0-9\+\-\s]{9,}$/',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // معالجة الصورة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة
            if ($department->image && file_exists(public_path($department->image))) {
                unlink(public_path($department->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/departments'), $imageName);
            $validated['image'] = 'uploads/departments/' . $imageName;
        }

        $department->update($validated);

        return redirect()->route('admin.departments.index')
            ->with('success', 'تم تحديث القسم بنجاح');
    }

    // حذف القسم
    public function destroy(Department $department)
    {
        // حذف الصورة
        if ($department->image && file_exists(public_path($department->image))) {
            unlink(public_path($department->image));
        }

        $department->delete();

        return redirect()->route('admin.departments.index')
            ->with('success', 'تم حذف القسم بنجاح');
    }
}