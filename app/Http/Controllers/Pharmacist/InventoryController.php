<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $medicines = Medicine::with(['prescriptions'])
            ->orderBy('name')
            ->paginate(20);

        $lowStockMedicines = Medicine::whereColumn('stock', '<=', 'low_stock_threshold')
            ->where('is_active', true)
            ->get();

        $expiringSoon = Medicine::where('expiration_date', '<=', now()->addDays(30))
            ->where('expiration_date', '>=', now())
            ->where('is_active', true)
            ->get();

        return view('pharmacist.inventory.index', compact('medicines', 'lowStockMedicines', 'expiringSoon'));
    }

    public function create()
    {
        return view('pharmacist.inventory.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'stock' => 'required|integer|min:0',
            'quantity' => 'required|numeric|min:0',
            'reserved_quantity' => 'nullable|numeric|min:0',
            'available_quantity' => 'nullable|numeric|min:0',
            'low_stock_threshold' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'production_date' => 'nullable|date|before_or_equal:today',
            'expiration_date' => 'nullable|date|after:today',
            'manufacturer' => 'nullable|string|max:255',
            'batch_number' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'availability_status' => 'nullable|string|in:available,unavailable,discontinued',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('medicines', 'public');
            $validated['image'] = $imagePath;
        }

        // Set default values
        $validated['reserved_quantity'] = $validated['reserved_quantity'] ?? 0;
        $validated['available_quantity'] = $validated['available_quantity'] ?? $validated['stock'];
        $validated['availability_status'] = $validated['availability_status'] ?? 'available';
        $validated['is_active'] = $request->has('is_active');

        Medicine::create($validated);

        return redirect()->route('pharmacist.inventory.index')
            ->with('success', 'تم إضافة الدواء بنجاح');
    }

    public function show(Medicine $medicine)
    {
        $medicine->load(['prescriptions' => function($query) {
            $query->latest()->take(10);
        }]);

        return view('pharmacist.inventory.show', compact('medicine'));
    }

    public function edit(Medicine $medicine)
    {
        return view('pharmacist.inventory.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_ar' => 'nullable|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'stock' => 'required|integer|min:0',
            'quantity' => 'required|numeric|min:0',
            'reserved_quantity' => 'nullable|numeric|min:0',
            'available_quantity' => 'nullable|numeric|min:0',
            'low_stock_threshold' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'production_date' => 'nullable|date|before_or_equal:today',
            'expiration_date' => 'nullable|date',
            'manufacturer' => 'nullable|string|max:255',
            'batch_number' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'availability_status' => 'nullable|string|in:available,unavailable,discontinued',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('medicines', 'public');
            $validated['image'] = $imagePath;
        }

        // Update available quantity based on stock and reserved
        $validated['available_quantity'] = $validated['stock'] - ($validated['reserved_quantity'] ?? 0);
        $validated['is_active'] = $request->has('is_active');

        $medicine->update($validated);

        return redirect()->route('pharmacist.inventory.index')
            ->with('success', 'تم تحديث الدواء بنجاح');
    }

    public function destroy(Medicine $medicine)
    {
        $medicine->delete();

        return redirect()->route('pharmacist.inventory.index')
            ->with('success', 'تم حذف الدواء بنجاح');
    }

    public function updateStock(Request $request, Medicine $medicine)
    {
        $validated = $request->validate([
            'stock' => 'required|integer|min:0',
            'quantity' => 'required|numeric|min:0',
        ]);

        $medicine->update($validated);

        return back()->with('success', 'تم تحديث المخزون بنجاح');
    }
}
