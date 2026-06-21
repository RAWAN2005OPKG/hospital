<?php

namespace App\Http\Controllers\Pharmacist;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Http\Request;

class PatientHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::with('user');

        // Search by name or ID
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $patients = $query->latest()->paginate(20);

        return view('pharmacist.patients.index', compact('patients'));
    }

    public function show(Patient $patient)
    {
        $patient->load('user');

        // Get patient's prescriptions
        $prescriptions = Prescription::where('patient_id', $patient->id)
            ->with(['doctor.user', 'medicines'])
            ->latest()
            ->get();

        // Get patient's invoices
        $invoices = Invoice::where('patient_id', $patient->user_id)
            ->with(['items.medicine', 'pharmacist'])
            ->latest()
            ->get();

        // Calculate statistics
        $stats = [
            'total_prescriptions' => $prescriptions->count(),
            'delivered_prescriptions' => $prescriptions->where('status', 'delivered')->count(),
            'pending_prescriptions' => $prescriptions->where('status', 'pending')->count(),
            'total_spent' => $invoices->where('status', 'paid')->sum('total_amount'),
            'total_invoices' => $invoices->count(),
        ];

        return view('pharmacist.patients.show', compact('patient', 'prescriptions', 'invoices', 'stats'));
    }

    public function prescriptionHistory(Patient $patient)
    {
        $prescriptions = Prescription::where('patient_id', $patient->id)
            ->with(['doctor.user', 'medicines'])
            ->latest()
            ->paginate(15);

        return view('pharmacist.patients.prescriptions', compact('patient', 'prescriptions'));
    }

    public function invoiceHistory(Patient $patient)
    {
        $invoices = Invoice::where('patient_id', $patient->user_id)
            ->with(['items.medicine', 'pharmacist'])
            ->latest()
            ->paginate(15);

        return view('pharmacist.patients.invoices', compact('patient', 'invoices'));
    }

    public function medicineHistory(Patient $patient)
    {
        // Get all medicines dispensed to this patient
        $prescriptions = Prescription::where('patient_id', $patient->id)
            ->where('status', 'delivered')
            ->with(['medicines'])
            ->latest()
            ->get();

        $medicines = collect();

        foreach ($prescriptions as $prescription) {
            foreach ($prescription->medicines as $medicine) {
                $medicines->push([
                    'medicine' => $medicine,
                    'prescription' => $prescription,
                    'dispensed_at' => $prescription->updated_at,
                ]);
            }
        }

        $medicines = $medicines->sortByDesc('dispensed_at');

        return view('pharmacist.patients.medicines', compact('patient', 'medicines'));
    }
}
