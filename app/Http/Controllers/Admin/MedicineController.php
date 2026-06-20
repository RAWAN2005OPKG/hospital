<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::latest()->paginate(10);
        return view('admin.medicines.index', compact('medicines'));
    }

    public function create()
    {
        return view('admin.medicines.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'low_stock_threshold' => 'required|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        Medicine::create($validated);

        return redirect()->route('admin.medicines.index')->with('success', 'تم إضافة الدواء بنجاح');
    }

    public function edit(Medicine $medicine)
    {
        return view('admin.medicines.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'low_stock_threshold' => 'required|integer|min:0',
            'price' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        // checkbox might not be sent if false
        $validated['is_active'] = $request->has('is_active');

        $medicine->update($validated);

        return redirect()->route('admin.medicines.index')->with('success', 'تم تحديث الدواء بنجاح');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();
        return redirect()->route('admin.medicines.index')->with('success', 'تم حذف الدواء بنجاح');
    }
}
