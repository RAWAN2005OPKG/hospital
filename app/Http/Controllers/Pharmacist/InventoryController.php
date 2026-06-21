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
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'quantity' => 'required|numeric|min:0',
            'low_stock_threshold' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'expiration_date' => 'nullable|date|after:today',
            'manufacturer' => 'nullable|string|max:255',
            'batch_number' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

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
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'quantity' => 'required|numeric|min:0',
            'low_stock_threshold' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'expiration_date' => 'nullable|date',
            'manufacturer' => 'nullable|string|max:255',
            'batch_number' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

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
