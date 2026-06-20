<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrescriptionController extends Controller
{
    public function index()
    {
        $prescriptions = Prescription::with(['patient.user', 'doctor.user', 'medicines'])
            ->latest()
            ->paginate(15);
            
        return view('pharmacist.prescriptions.index', compact('prescriptions'));
    }

    public function show(Prescription $prescription)
    {
        $prescription->load(['patient.user', 'doctor.user', 'medicines']);
        return view('pharmacist.prescriptions.show', compact('prescription'));
    }

    public function markAsDelivered(Prescription $prescription)
    {
        if ($prescription->status === 'delivered') {
            return back()->with('error', 'هذه الوصفة تم تسليمها مسبقاً.');
        }

        try {
            DB::transaction(function () use ($prescription) {
                // Deduct stock for each medicine
                foreach ($prescription->medicines as $medicine) {
                    // Check if stock is sufficient (optional, or just deduct)
                    if ($medicine->stock > 0) {
                        $medicine->decrement('stock', 1); // Deducting 1 unit of medicine (can be adjusted based on dosage/days if needed, but usually 1 pack)
                    }
                }

                $prescription->update(['status' => 'delivered']);
            });

            return back()->with('success', 'تم تسليم الأدوية وتحديث المخزون بنجاح.');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء التحديث.');
        }
    }
}
